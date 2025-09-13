<?php

use App\Http\Controllers\WatchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\CheckBasket;
use App\Http\Middleware\CheckOrder;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('admin.index');

Route::resource('/brend', 'App\Http\Controllers\BrendController');
Route::resource('/mechanism', 'App\Http\Controllers\MechanismController');
Route::resource('/style', 'App\Http\Controllers\StyleController');
Route::resource('/watch', 'App\Http\Controllers\WatchController')->middleware('auth:web');
Route::resource('/photo', 'App\Http\Controllers\PhotoController');
Route::resource('/promoCode', 'App\Http\Controllers\PromoCodeController')->middleware('auth:web');
Route::resource('/order', 'App\Http\Controllers\OrderController')->middleware('auth:web');

Route::post('/promoCode/generate', 'App\Http\Controllers\PromoCodeController@generatePromoCode')->middleware('auth:web')->name('promoCode.generate');
Route::get('/order/paymentInfo/{numberOrder}', 'App\Http\Controllers\OrderController@getPaymentInfo')->middleware('auth:web')->name('order.paymentInfo');
Route::patch('/order/updateOrderStatus/{idOrder}/{orderStatus}', 'App\Http\Controllers\OrderController@updateOrderStatus')->middleware('auth:web')->name('order.updateStatus');

Route::get('photo/create/{id}', 'App\Http\Controllers\PhotoController@showCreatePhoto')->name('photo.showCreate');
Route::get('photo/all/{id}', 'App\Http\Controllers\PhotoController@showAllPhoto')->name('photo.showAll');
Route::post('photo/{idWatch}', 'App\Http\Controllers\PhotoController@addPhotoDb')->name('photo.addDb');
Route::delete('photo/deleteAll/{id}', 'App\Http\Controllers\PhotoController@destroyAll')->name('photo.destroyAll');

Route::get('/register/show', 'App\Http\Controllers\EmployeeController@show')->name('register.show');
Route::post('/register/employee', 'App\Http\Controllers\EmployeeController@registrEmplyee')->name('register.employee');

Route::prefix('admin')->group(function () {
    Auth::routes();
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', 'App\Http\Controllers\WatchController@indexUser')->name('index.user');
Route::get('/show/{id}', 'App\Http\Controllers\WatchController@showWatch')->name('show.user');
Route::get('/basket/{mode}/{id}', 'App\Http\Controllers\BasketController@actionBasket')->name('basket.mode');
Route::get('/clear-all-filters', function () {
    Session::forget('mechanismFilter');
    Session::forget('brendFilter');
    Session::forget('styleFilter');
    Session::forget('genderFilter');
    Session::forget('priceMin');
    Session::forget('priceMax');
    return redirect()->route('index.user')->with('succes', 'Фільтри очищені!');
})->name('clear.allFilters');
Route::get('/basket/calculator', 'App\Http\Controllers\BasketController@totalCostWatch')->name('basket.calculator')->middleware(CheckBasket::class);
Route::get('/checkout', 'App\Http\Controllers\OrderController@checkout')->name('checkout.user')->middleware(CheckBasket::class);
Route::post('/registration/buyer', 'App\Http\Controllers\BuyerController@registration')->name('registration.buyer');
Route::post('/smallRegistration/buyer', 'App\Http\Controllers\BuyerController@smallRegistration')->name('smallRegistration.buyer');
Route::get('/login/buyer', 'App\Http\Controllers\BuyerController@authenticate')->name('authenticate.buyer');
Route::patch('/update/buyer/{idBuyer}', 'App\Http\Controllers\BuyerController@updateBuyer')->middleware('auth:buyers')->name('update.buyer');
//Верифікація пошти
Route::get('/emailBuyer/verify', function () {
    if (auth('buyers')->user()->hasVerifiedEmail()){
        return back()->with('succes', 'Ви вже підтвердили свою пошту!');
    }
    return view('user.buyer.emailCheck');
})->middleware('auth:buyers')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    if (auth('buyers')->user()->hasVerifiedEmail()){
        return back()->with('succes', 'Ви вже підтвердили свою пошту!');
    }
    $request->fulfill();
    return redirect()->route('index.user')->with('succes', 'Вашу пошту успішно підтверджено!');
})->middleware(['auth:buyers', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    if (auth('buyers')->user()->hasVerifiedEmail()){
        return back()->with('succes', 'Ви вже підтвердили свою пошту!');
    }
    $request->user()->sendEmailVerificationNotification();
    return back()->with('succes', 'Електронний лист надіслано!');
})->middleware(['auth:buyers', 'throttle:6,1'])->name('verification.send');
//Вихід з аккаунта
Route::post('/buyer/logout', 'App\Http\Controllers\BuyerController@buyerLogout')->middleware('auth:buyers')->name('logout.buyer');
//Зміна пароля
Route::get('/buyer/forgot-password', 'App\Http\Controllers\BuyerController@showResetPassword')->middleware('guest:buyers')->name('buyers.password.request');
Route::post('/send/forgot-password', function (Request $request){
    $request->validate(['email'=>'required|email']);
    $status=Password::broker('buyers')->sendResetLink($request->only('email'));
    return $status === Password::ResetLinkSent
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest:buyers')->name('buyers.password.email');
Route::get('/buyer/reset-password/{token}', function (string $token){ return view('user.buyer.resetPassword', ['token'=>$token]);})->middleware('guest:buyers')->name('buyers.password.reset');
Route::post('/buyer/reset-password', 'App\Http\Controllers\BuyerController@updatePassword')->middleware('guest:buyers')->name('buyers.password.update');


Route::get('/login/google', function () { Session::put('previsionUrl', url()->previous()); return Socialite::driver('google')->redirect(); })->name('login.google');
Route::get('/auth/google/callback', 'App\Http\Controllers\BuyerController@authenticationGoogleBuyers');
Route::get('/registration/google', function () { Session::put('previsionUrl', url()->previous()); Session::put('registration', true); return Socialite::driver('google')->redirect(); })->name('registration.google');

Route::post('/add/deliveryAddress', 'App\Http\Controllers\AddressController@addDeliveryAddress')->middleware('auth:buyers')->name('add.deliveryAddress');
Route::patch('/update/deliveryAddress/{idAddress}', 'App\Http\Controllers\AddressController@updateDeliveryAddress')->middleware('auth:buyers')->name('update.deliveryAddress');

Route::post('/order/confirm', 'App\Http\Controllers\OrderController@confirmOrder')->middleware(['auth:buyers'])->name('order.confirm');
Route::post('/liqPay/callback', 'App\Http\Controllers\OrderController@callBack')->name('liqPay.callback');
Route::get('/result/order', 'App\Http\Controllers\OrderController@resultPay')->name('result.order');

Route::post('/NovaPost/getCities', 'App\Http\Controllers\NovaPostController@getCitiesNp')->middleware('auth:buyers')->name('novaPost.getCities');
Route::post('/NovaPost/getWarehouses', 'App\Http\Controllers\NovaPostController@getWarehousesNp')->middleware('auth:buyers')->name('novaPost.getWarehouses');
Route::post('/NovaPost/AddAddress', 'App\Http\Controllers\NovaPostController@addAddressNp')->middleware('auth:buyers')->name('novaPost.addAddress');
Route::post('/NovaPost/searchWarehouses', 'App\Http\Controllers\NovaPostController@searchWarehousesNp')->middleware('auth:buyers')->name('novaPost.searchWarehouses');
Route::patch('/NovaPost/UpdateAddress/{idNovaPost}', 'App\Http\Controllers\NovaPostController@updateAddressNp')->middleware('auth:buyers')->name('novaPost.updateAddress');
//Route::get('/addToDb/NovaPost', 'App\Http\Controllers\NovaPostController@addNovaPostToDb')->name('addToDb.NovaPost');

Route::post('/promo/apply','App\Http\Controllers\OrderController@promoCodeApply')->middleware(['auth:buyers', CheckBasket::class])->name('promo.apply');
Route::post('/promo/remove', function (){
    if (!session('promoCode')){
        return back()->withErrors('Таку дію виконати неможна!');
    }else{
    WatchController::removeDiscountFromWatch();
    Session::forget('promoCode');}
    return back()->with('succes', 'Промокод успішно прибрано!');})->middleware(['auth:buyers', CheckBasket::class])->name('promo.remove');
