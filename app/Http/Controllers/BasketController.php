<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\WatchController;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\BasketRequest;

class BasketController extends Controller
{
    public function actionBasket($mode, $idWatch)
    {
        $rezult=WatchController::checkWatchKolvo($idWatch);
        if ($rezult) {
            if (!empty($idWatch) && $mode == 'add') {
                if (!Session::has('basket')) {
                    Session::put('basket', []);
                }
                if (empty(session('basket'))) {
                    Session::put('basket', WatchController::watchBasket($idWatch, 1));
                } else {
                    $basket = Session::get('basket');
                    $basket[] = WatchController::watchBasket($idWatch, 1)[0];
                    Session::put('basket', $basket);
                }
            }
            if (session('basket') && $mode == 'clear') {
                Session::forget('basket');
                Session::forget('totalCost');
            }
            if (session('basket') && !empty($idWatch) && $mode == 'del') {
                $sessionBasket = Session::get('basket');
                if (count($sessionBasket) > 0) {
                    for ($i = 0; $i < count($sessionBasket); $i++) {
                        if ($sessionBasket[$i]['idWatch'] == $idWatch) {
                            unset($sessionBasket[$i]);
                            break;
                        }
                    }
                    $items = [];
                    foreach ($sessionBasket as $item) {
                        if (!empty($item)) {
                            $items[] = $item;
                        }
                    }
                    Session::put('basket', $items);
                }
            }
            if (session('basket')) {
                if (session('promoCode')) {
                    $basket = session('basket');
                    $discountValue = session('promoCode')['discountValue'];
                    for ($i = 0; $i < count($basket); $i++) {
                        if (!isset($basket[$i]['activePromo']) || $basket[$i]['activePromo'] == false) {
                            $basket[$i]['price'] = $basket[$i]['price'] - ($basket[$i]['price'] * $discountValue / 100);
                            $basket[$i]['activePromo'] = true;
                        }
                    }
                    Session::put('basket', $basket);
                }
                $totalCost = 0;
                foreach (session('basket') as $itemSession) {
                    $totalCost += $itemSession['price'] * $itemSession['kolvo'];
                }
                Session::put('totalCost', $totalCost);
            }
        }
        else{
            return back()->withErrors('Даного товара немає в наявності!');
        }
        return back()->with('open_modal', true);
    }

    public static function totalCostWatch(BasketRequest $request)
    {
        $totalCost=0;
        if ($request->watchList) {
            $rezultSession=Session::get('basket');
            for ($i = 0; $i < count($rezultSession); $i++) {
                $kolvo = 'kolvo' . $rezultSession[$i]['idWatch'];
                $rezultSession[$i]['kolvo'] = $request->$kolvo;
                $totalCost += $rezultSession[$i]['price'] * $rezultSession[$i]['kolvo'];
            }
            Session::put('basket', $rezultSession);
            Session::put('totalCost', $totalCost);
            return back()->with('open_modal', true);
        }
        else{
            return back()->withErrors('Щось пішло не так!');
        }
    }

}
