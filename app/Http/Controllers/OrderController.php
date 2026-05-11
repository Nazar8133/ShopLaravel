<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmed;
use App\Models\Buyer;
use App\Notifications\BuyerSendPromoCode;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\NovaPostController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\WatchController;
use App\Http\Controllers\BuyerController;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Notification;


class OrderController extends Controller
{
    public function checkout()
    {
        //Session::forget(['selectCity', 'warehouses', 'searchCity']);
        $pib=[];
        $kolvoBasket=0;
        $address=0;
        $issetNovaPost=0;
        if (Auth::guard('buyers')->check()) {
            if (Auth::guard('buyers')->user()->pib!=null) {
                $pib = explode(' ', Auth::guard('buyers')->user()->pib);
            }
            if (Auth::guard('buyers')->user()->idAddress!=null){
                $address=AddressController::getDeliveryAddressById(Auth::guard('buyers')->user()->idAddress);
            }
            if (Auth::guard('buyers')->user()->idNovaPost!=null){
                $issetNovaPost=true;
            }
            if (Auth::guard('buyers')->user()->idNovaPost!=null && !session('selectCity') && !session('selectWarehouses') && !session('warehouses') && !session('selectCityRef')){
                $rezult=NovaPostController::getNovaPostAddressById(Auth::guard('buyers')->user()->idNovaPost);
                if (!$rezult){
                    session()->flash('errorNp', 'Нажаль ми не змогли найти відділення яке ви вибрали раніше, можливо Нова пошта більше його не обслуговує, просимо вас обрати нове відділення!');
                }
            }
        }
        foreach (session('basket') as $tmpSession){
            $kolvoBasket+=$tmpSession['kolvo'];
        }
        return view('user.watch.checkout', compact('kolvoBasket', 'pib', 'address', 'issetNovaPost'));
    }

    public function confirmOrder(OrderRequest $request)
    {
        //dd($request);
        $buyer=Auth::guard('buyers')->user();
        if (is_null($buyer->pib) || is_null($buyer->number)){
            return back()->withErrors(['errorGuest'=>'Для того щоб оформити замовлення потрібно заповнити всі контактні данні, а саме номер телефону та ПІБ!']);
        }
        else {
            if ($request->has('orderConfirm') || $request->has('googlePayToken')) {
                foreach (session('basket') as $tmpBasket) {
                    $watches[] = ['id' => $tmpBasket['idWatch'], 'kolvo' => $tmpBasket['kolvo']];
                }
                $jsonWatches = json_encode($watches);
                $promoCode = null;
                $rezultOrder = false;
                if (session('promoCode')) {
                    $promoCode = session('promoCode')['idPromoCode'];
                }
                if (session('numberOrder') && $request->selected_payment == 'liqPay') {
                    $rezult = Order::select('watches', 'idPromoCode', 'delivery', 'payment')->where('numberOrder', session('numberOrder'))->first();
                    if ($rezult->watches != $jsonWatches || $rezult->idPromoCode != $promoCode || $rezult->delivery != $request->selected_delivery || $rezult->payment != $request->selected_payment) {
                        $order = Order::where('numberOrder', session('numberOrder'))->first();
                        $rezultOrder = true;
                    } else {
                        return self::liqPay(session('numberOrder'));
                    }
                } else {
                    $order = new Order();
                    $order->numberOrder = strtoupper(uniqid());
                }
                $order->idBuyer = Auth::guard('buyers')->user()->idBuyer;
                $order->watches = $jsonWatches;
                $order->delivery = $request->selected_delivery;
                $order->payment = $request->selected_payment;
                $order->idPromoCode = $promoCode;
                if ($request->koment != null) {
                    $order->koment = $request->koment;
                }
                if ($request->selected_payment == 'cash' || $request->selected_payment == 'googlePay') {
                    if ($request->selected_payment=='cash'){
                        $order->paymentStatus = 2;
                    }
                    else{
                        $order->paymentStatus = 1;
                    }
                    $order->orderStatus = 2;
                    if ($rezultOrder) {
                        $order->update();
                    } else {
                        $order->save();
                    }
                    self::sendOrderConfirmedEmail($order->toArray(), session('basket'), session('promoCode'), session('totalCost'));
                    WatchController::updateWatchKolvo(session('basket'));
                    if ($promoCode) {
                        PromoCodeController::promoCodeUpdate($promoCode);
                    }
                    Session::forget(['basket', 'totalCost', 'promoCode', 'numberOrder']);
                    return redirect()->route('index.user')->with('succes', 'Замовлення успішно створено, наш консультант скоро з вами зв\'яжеться!');
                }
                elseif ($request->selected_payment == 'liqPay') {
                    $order->paymentStatus = 2;
                    $order->orderStatus = 2;
                    if ($rezultOrder) {
                        $order->update();
                    } else {
                        Session::put('numberOrder', $order->numberOrder);
                        $order->save();
                    }
                    return self::liqPay($order->numberOrder);
                }
            } else {
                return back()->withErrors(['errorGuest' => 'Помилка оформлення замовлення!']);
            }
        }
    }

    public static function sendOrderConfirmedEmail($order, $watch, $promoCode, $totalCost)
    {
        $buyer=Auth::guard('buyers')->user()->toArray();
        if($order['delivery']=='nova_post'){
            $rezult=NovaPostController::getBuyerNovaPostAddress($buyer['idNovaPost']);
            $delivery=$rezult->city.', '.$rezult->warehouse;
        }
        elseif ($order['delivery']=='courier_delivery'){
            $rezult=AddressController::getDeliveryAddressById($buyer['idAddress']);
            $delivery=$rezult->region.', '.$rezult->city.', '.$rezult->street.' '.($rezult->houseNumber ?? $rezult->apartmentNumber);
        }
        else{
            $delivery='Самовивіз з нашого магазину';
        }

        if ($order['payment']=='liqPay'){
            $privateKey=config('services.liqpay.private_key');
            $publicKey=config('services.liqpay.public_key');
            $params = [
                'public_key'     => $publicKey,
                'action'         => 'status',
                'order_id'       => $order['numberOrder'],
                'version'        => '3',
            ];
            $date=base64_encode(json_encode($params));
            $signature=base64_encode(sha1($privateKey.$date.$privateKey, true));
            $response=Http::asForm()->post('https://www.liqpay.ua/api/request', ['data'=>$date, 'signature'=>$signature])->json();
            $cardType=strtoupper($response['sender_card_type'] ?? 'LIQPAY');
            $cardMask=$response['sender_card_mask2'] ?? '';
            $payment=trim($cardType.' '.$cardMask);
        }
        elseif ($order['payment']=='googlePay'){
            $payment='GooglePay';
        }
        else{
            $payment='Оплата при отриманні';
        }
        Mail::to($buyer['email'])->queue(new OrderConfirmed($order, $watch, $promoCode ?? [], $buyer, $delivery, $payment, $totalCost));
    }


    public static function liqPay($orderId)
    {
        $privateKey=config('services.liqpay.private_key');
        $publicKey=config('services.liqpay.public_key');
        if (!$privateKey || !$publicKey) {
            return redirect()->route('checkout.user')->withErrors(['errorGuest' => 'Не налаштовані ключі LiqPay.']);
        }
        $params = [
            'public_key'     => $publicKey,
            'action'         => 'pay',
            'amount'         => (float) session('totalCost'),
            'currency'       => 'UAH',
            'description'    => 'Оплата замовлення в Магазині годинників',
            'order_id'       => $orderId,
            'paytypes'       => 'card, privat24, qr',
            'version'        => '3',
            'server_url'     => route('liqPay.callback'),
            'result_url'     => route('result.order')
        ];
        if (config('services.liqpay.sandbox') || strpos($publicKey, 'sandbox_') === 0) {
            $params['sandbox'] = '1';
        }
        $date=base64_encode(json_encode($params));
        $signature=base64_encode(sha1($privateKey.$date.$privateKey, true));
        return view('user.watch.liqPayForm', compact('date', 'signature'));
    }

    public function resultPay()
    {
        $order=Order::where('numberOrder', session('numberOrder'))->first();
        if (!$order){
            return redirect()->route('checkout.user')->withErrors(['errorGuest'=>'Замовлення не знайдено!']);
        }
        if ($order->payment=='liqPay' && $order->paymentStatus==2){
            self::syncLiqPayStatus($order);
            $order->refresh();
        }
        if ($order->paymentStatus==1){
            self::sendOrderConfirmedEmail($order->toArray(), session('basket'), session('promoCode'), session('totalCost'));
            WatchController::updateWatchKolvo(session('basket'));
            if (session('promoCode')) {
                PromoCodeController::promoCodeUpdate(session('promoCode')['idPromoCode']);
            }
            Session::forget(['basket', 'totalCost', 'promoCode', 'numberOrder']);
            return redirect()->route('index.user')->with('succes', 'Замовлення оформлено успішно! Оплата пройшла успішно.');
        }
        elseif ($order->paymentStatus==0){
            return redirect()->route('checkout.user')->withErrors(['errorGuest'=>'Неуспішний платіж, спробуйте оплатити замовлення знову!']);
        }
        elseif ($order->paymentStatus==2){
            return redirect()->route('checkout.user')->withErrors(['errorGuest'=>'Платіж ще обробляється. Оновіть сторінку через кілька секунд або спробуйте оплатити ще раз.']);
        }
        else{
            return redirect()->route('checkout.user')->withErrors(['errorGuest'=>'Невідома помилка при оплаті!']);
        }
    }

    public function callBack(Request $request)
    {
        $privateKey = config('services.liqpay.private_key');
        $dataLiqPay = $request->input('data');
        $signatureLiqPay = $request->input('signature');
        $signature = base64_encode(sha1($privateKey . $dataLiqPay . $privateKey, true));

        if ($signature === $signatureLiqPay) {
            $decoded = json_decode(base64_decode($dataLiqPay), true);
            if (in_array($decoded['status'] ?? null, ['success', 'sandbox'], true)){
                Order::where('numberOrder', $decoded['order_id'])->update(['idPayment'=>$decoded['payment_id'] ?? null, 'paymentStatus' => 1]);
            }
            elseif (in_array($decoded['status'] ?? null, ['error', 'failure'], true)){
                Order::where('numberOrder', $decoded['order_id'])->update(['idPayment'=>$decoded['payment_id'] ?? null, 'paymentStatus' => 0]);
            }
            return response('OK', 200);
        }
        else{
            return response('Invalid signature', 403);
        }
    }

    private static function syncLiqPayStatus(Order $order): void
    {
        $privateKey=config('services.liqpay.private_key');
        $publicKey=config('services.liqpay.public_key');
        $params = [
            'public_key' => $publicKey,
            'action' => 'status',
            'order_id' => $order->numberOrder,
            'version' => '3',
        ];
        $data=base64_encode(json_encode($params));
        $signature=base64_encode(sha1($privateKey.$data.$privateKey, true));
        $response=Http::asForm()->post('https://www.liqpay.ua/api/request', ['data'=>$data, 'signature'=>$signature])->json();
        if (in_array($response['status'] ?? null, ['success', 'sandbox'], true)){
            $order->update(['idPayment'=>$response['payment_id'] ?? null, 'paymentStatus'=>1]);
        }
        elseif (in_array($response['status'] ?? null, ['error', 'failure'], true)){
            $order->update(['idPayment'=>$response['payment_id'] ?? null, 'paymentStatus'=>0]);
        }
    }

    public function promoCodeApply(Request $request)
    {
        $request->validate([
            'promoCode' => 'required|regex:/^\d{4}-\d{4}-\d{4}-\d{4}$/u'
        ], [
            'promoCode.regex' => 'Неправильний формат промокода!'
        ]);
        $promoCode=PromoCodeController::promoCodeCheck($request->promoCode);
        if (session('promoCode')){
            return back()->withErrors(['errorGuest'=>'Ви вже ввели промокод!']);
        }
        elseif (!empty($promoCode)){
            if ($promoCode->dateStart<=now() && $promoCode->dateEnd>=now()){
                $rezult=Order::select('idPromoCode', 'paymentStatus')->where('idBuyer', Auth::guard('buyers')->user()->idBuyer)->get();
                foreach ($rezult as $tmpRezult){
                    if ($tmpRezult->idPromoCode==$promoCode->idPromoCode && $tmpRezult->paymentStatus==1){
                        return back()->withErrors(['promoCode'=>'Ви вже використали цей промокод!']);
                    }
                }
                $totalCost=session('totalCost');
                $basket=session('basket');
                $newTotalCost=$totalCost-($totalCost*$promoCode->discountValue/100);
                for ($i=0; $i<count($basket); $i++){
                    $basket[$i]['price']=$basket[$i]['price']-($basket[$i]['price']*$promoCode->discountValue/100);
                    $basket[$i]['activePromo']=true;
                }
                $promo=['idPromoCode'=>$promoCode->idPromoCode,'code'=>$promoCode->code, 'discountValue'=>$promoCode->discountValue];
                Session::put('promoCode', $promo);
                Session::put('basket', $basket);
                Session::put('totalCost', $newTotalCost);
                return back()->with('succes', 'Промокод активовано!');
            }
            else{
                return back()->withErrors(['promoCode'=>'Промокод недійсний!']);
            }
        }
        else{
            return back()->withErrors(['promoCode'=>'Такого промокода неіснує!']);
        }
    }

    public function index()
    {
        $order=Order::select('idOrder', 'numberOrder', 'idBuyer', 'paymentStatus', 'orderStatus')->orderBy('created_at', 'asc')->paginate(8);
        return view('admin.order.index', compact('order'));
    }

    public function show(string $id)
    {
        $promoCode='';
        $arrWatch=[];
        $totalCost=0;
        $deliveryAddress='';
        $order=Order::find($id);
        $buyer=BuyerController::getBuyer($order->idBuyer);
        if ($order->delivery=='nova_post'){
            $deliveryAddress=NovaPostController::getBuyerNovaPostAddress($buyer['idNovaPost']);
        }
        elseif ($order->delivery=='courier_delivery'){
            $deliveryAddress=AddressController::getDeliveryAddressById($buyer['idAddress']);
        }
        $watch=json_decode($order->watches, true);
        for ($i=0; $i<count($watch); $i++){
            $arrWatch[]=WatchController::watchBasket($watch[$i]['id'], $watch[$i]['kolvo'])[0];
            $totalCost+=$arrWatch[$i]['price']*$arrWatch[$i]['kolvo'];
        }
        if ($order->idPromoCode!=null){
            $promoCode=PromoCodeController::getPromoCode(1);
            $totalCost=$totalCost-($totalCost*$promoCode['discountValue']/100);
            for ($i=0; $i<count($arrWatch); $i++){
                $arrWatch[$i]['price']=$arrWatch[$i]['price']-($arrWatch[$i]['price']*$promoCode['discountValue']/100);
            }
        }
        if (empty($order)){
            return view('admin.index');
        }
        return view('admin.order.show', compact('order', 'promoCode', 'arrWatch', 'totalCost', 'buyer', 'deliveryAddress'));
    }

    public function getPaymentInfo($numberOrder)
    {
        $privateKey=config('services.liqpay.private_key');
        $publicKey=config('services.liqpay.public_key');
        $params = [
            'public_key'     => $publicKey,
            'action'         => 'status',
            'order_id'       => $numberOrder,
            'version'        => '3',
        ];
        $date=base64_encode(json_encode($params));
        $signature=base64_encode(sha1($privateKey.$date.$privateKey, true));
        $response=Http::asForm()->post('https://www.liqpay.ua/api/request', ['data'=>$date, 'signature'=>$signature])->json();
        $response['create_date']=Carbon::createFromTimestampMs($response['create_date'])->format('d.m.Y H:i:s');
        $response['end_date']=Carbon::createFromTimestampMs($response['end_date'])->format('d.m.Y H:i:s');
        return view('admin.order.paymentInfo', compact('response'));
    }

    public function updateOrderStatus(string $idOrder, Request $request)
    {
        $order=Order::find($idOrder);
        $order->orderStatus=$request->orderStatus;
        $order->update();
        return back()->with('succes', 'Статус успішно оновлено!');
    }

    public static function topIdBuyers($promoCode, $discountValue, $dateStart, $dateEnd)
    {
        $rezultTop=[];
        $rezultKolvo=0;
        $id=0;
        $rezult = Order::select('idBuyer', 'watches')->get();
        //dd($rezult);
        $kolvoRezult=count($rezult);
        for($i=0; $i<$kolvoRezult; $i++){
            if ($rezultKolvo==0){
                $id=$rezult[$i]['idBuyer'];
            }
            if ($rezult[$i]['idBuyer']==$id){
                $arrayWatch=json_decode($rezult[$i]['watches'], true);
                foreach ($arrayWatch as $tmpArrayWatch){
                    $rezultKolvo+=$tmpArrayWatch['kolvo'];
                }
            }
            if($id!=$rezult[$i]['idBuyer'] || $i==$kolvoRezult-1){
                $rezultTop[$id]=['kolvoTovat'=>$rezultKolvo];
                $rezultKolvo=0;
                if (count($rezultTop)==10){
                    break;
                }
                if ($i!=$kolvoRezult-1){
                    $i--;
                }
            }
        }
        arsort($rezultTop);
        $arrEmails=BuyerController::getBuyerEmail($rezultTop);
        $time=0;
        foreach ($arrEmails as $items) {
            Notification::send($items, new BuyerSendPromoCode($promoCode, $discountValue, $dateStart, $dateEnd));
            $time+=15;
            sleep($time);
        }
        //dd($arrEmails);
        /*$arrRez=$rezult->groupBy('idBuyer');
        foreach ($arrRez as $idBuyer=>$arrWatch) {
            $kolvo = 0;

            foreach ($arrWatch as $item) {
                $arrayWatch = json_decode($item->watches, true);
                foreach ($arrayWatch as $watch) {
                    $kolvo += $watch['kolvo'];
                }
            }

            $rezultTop[$idBuyer] = [
                'kolVoTovat' => $kolvo,
            ];
        }*/
    }
}
