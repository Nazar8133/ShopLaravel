<?php

namespace App\Http\Controllers;

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
                if (session('numberOrder') && $request->selected_payment == 'cardPrivat') {
                    $rezult = Order::select('watches', 'idPromoCode', 'delivery', 'payment')->where('numberOrder', session('numberOrder'))->first();
                    if ($rezult->watches != $jsonWatches || $rezult->idPromoCode != $promoCode || $rezult->delivery != $request->selected_delivery || $rezult->payment != $request->selected_payment) {
                        $order = Order::where('numberOrder', session('numberOrder'))->first();
                        $rezultOrder = true;
                    } else {
                        $url = self::liqPay(session('numberOrder'));
                        return redirect()->away($url);
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
                if ($request->selected_payment == 'liqPay') {
                    $order->paymentStatus = 2;
                    $order->orderStatus = 2;
                    if ($rezultOrder) {
                        $order->update();
                    } else {
                        Session::put('numberOrder', $order->numberOrder);
                        $order->save();
                    }
                    $url = self::liqPay($order->numberOrder);
                    return redirect()->away($url);
                } elseif ($request->selected_payment == 'cash') {
                    $order->paymentStatus = 2;
                    $order->orderStatus = 2;
                    if ($rezultOrder) {
                        $order->update();
                    } else {
                        $order->save();
                    }
                    WatchController::updateWatchKolvo(session('basket'));
                    if (session('promoCode')) {
                        PromoCodeController::promoCodeUpdate(session('promoCode')['idPromoCode']);
                    }
                    Session::forget(['basket', 'totalCost', 'promoCode', 'numberOrder']);
                    return redirect()->route('index.user')->with('succes', 'Замовлення успішно створено, наш консультант скоро з вами зв\'яжеться!');
                } elseif ($request->selected_payment == 'googlePay') {
                    $order->paymentStatus = 1;
                    $order->orderStatus = 2;
                    $order->save();
                    WatchController::updateWatchKolvo(session('basket'));
                    if (session('promoCode')) {
                        PromoCodeController::promoCodeUpdate(session('promoCode')['idPromoCode']);
                    }
                    Session::forget(['basket', 'totalCost', 'promoCode', 'numberOrder']);
                    return redirect()->route('index.user')->with('succes', 'Замовлення успішно створено, наш консультант скоро з вами зв\'яжеться!');
                }
            } else {
                return back()->withErrors(['errorGuest' => 'Помилка оформлення замовлення!']);
            }
        }
    }


    public static function liqPay($orderId)
    {
        $privateKey=config('services.liqpay.private_key');
        $publicKey=config('services.liqpay.public_key');
        $params = [
            'public_key'     => $publicKey,
            'action'         => 'pay',
            'amount'         => session('totalCost'),
            'currency'       => 'UAH',
            'description'    => 'Оплата замовлення в Магазині годинників',
            'order_id'       => $orderId,
            'paytypes'       => 'card, privat24, qr',
            'version'        => '3',
            'server_url'     => route('liqPay.callback'),
            'result_url'     => route('result.order')
        ];
        $date=base64_encode(json_encode($params));
        $signature=base64_encode(sha1($privateKey.$date.$privateKey, true));
        $response=Http::asForm()->post('https://www.liqpay.ua/api/3/checkout', ['data'=>$date, 'signature'=>$signature]);
        $url = $response->transferStats->getEffectiveUri()->__toString();
        return $url;
    }

    public function resultPay()
    {
        $order=Order::where('numberOrder', session('numberOrder'))->first();
        if ($order->paymentStatus==1){
            WatchController::updateWatchKolvo(session('basket'));
            if (session('promoCode')) {
                PromoCodeController::promoCodeUpdate(session('promoCode')['idPromoCode']);
            }
            Session::forget(['basket', 'totalCost', 'promoCode', 'numberOrder']);
            return redirect()->route('index.user')->with('succes', 'Замовлення оформлено успішно!');
        }
        elseif ($order->paymentStatus==0){
            return redirect()->route('checkout.user')->withErrors(['errorGuest'=>'Неуспішний платіж, спробуйте оплатити замовлення знову!']);
        }
        elseif ($order->paymentStatus==2){
            return redirect()->route('checkout.user')->withErrors(['errorGuest'=>'Ви покинули сторінку оплати!']);
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
            if ($decoded['status']=='success'){
                Order::where('numberOrder', $decoded['order_id'])->update(['idPayment'=>$decoded['payment_id'], 'paymentStatus' => 1]);
            }
            elseif ($decoded['status']=='error' || $decoded['status']=='failure'){
                Order::where('numberOrder', $decoded['order_id'])->update(['idPayment'=>$decoded['payment_id'], 'paymentStatus' => 0]);
            }
            return response('OK', 200);
        }
        else{
            return response('Invalid signature', 403);
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
}
