<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckBasket
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('basket') || empty(Session::get('basket'))){
           return redirect()->route('index.user')->withErrors('Неможливо оформити замовлення доки товарів немає в корзині!');
        }
        else{
            return $next($request);
        }
    }
}
