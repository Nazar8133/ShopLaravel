<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegistBuyerRequest;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\UpdateBuyerRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\SmallRegistrationBuyerRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\Mail\AccountGoogleCreated;

class BuyerController extends Controller
{
    public function registration(RegistBuyerRequest $request)
    {
            /*$pib=explode(' ', $request->pib);
            $buyer=new Buyer();
            $buyer->firstName=$pib[1];
            $buyer->lastName=$pib[0];
            $buyer->middleName=$pib[2];
            $buyer->number=$request->number;
            $buyer->email=$request->email;
            $buyer->password=Hash::make($request->password);
            $buyer->save();
            return redirect()->route('checkout.user')->with('succes', 'Ви успішно зареєструвались, тепер залогіньтесь!');*/
            $buyer = Buyer::create([
                'pib' => $request->pib,
                'number' => $request->numberReg,
                'email' => $request->emailReg,
                'password' => Hash::make($request->password)
            ]);
            event(new Registered($buyer));
            Auth::guard('buyers')->login($buyer);
            Mail::to($buyer->email)->later(now()->addMinutes(2), new AccountCreated($buyer->pib));
            return redirect()->route('verification.notice');
    }

    public function smallRegistration(SmallRegistrationBuyerRequest $request)
    {
        $buyer = Buyer::create([
            'email' => $request->emailReg,
            'password' => Hash::make($request->password)
        ]);
        event(new Registered($buyer));
        Auth::guard('buyers')->login($buyer);
        Mail::to($buyer->email)->later(now()->addMinutes(2), new AccountCreated($buyer->email));
        return redirect()->route('verification.notice');
    }

    /*public function login(DeliveryAddressRequest $request)
    {
        $buyer=Buyer::where('email', $request->email)->first();
        if (empty($buyer)){
            return back()->with('errorEmail', 'Акаунта з такою електронною поштою не існує!');
        }
        elseif (Hash::check($request->password, $buyer->password)){
            Session::put('buyer', ['idBuyer'=>$buyer->idBuyer, 'firstName'=>$buyer->firstName, 'lastName'=>$buyer->lastName, 'middleName'=>$buyer->middleName, 'number'=>$buyer->number, 'email'=>$buyer->email, 'idAddress'=>$buyer->idAddress]);
            return back()->with('succes', 'Вхід успішний!');
        }
        else{
            return back()->with('errorPasswordCheck', 'Введено невірний пароль!');
        }
    }*/
    public function authenticate(Request $request)
    {
        $credentials=$request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $remember=$request->has('remember');

        if (Auth::guard('buyers')->attempt($credentials, $remember)){
            $request->session()->regenerate();
            return back()->with('succes', 'Вхід успішний!');
        }
        return back()->withErrors(['email'=>'Такого аккаунту неіснує!'])->onlyInput('email');

    }

    public function buyerLogout(Request $request)
    {
        Auth::guard('buyers')->logout();
        $request->session()->flush();
        $request->session()->regenerateToken();
        return redirect()->route('index.user')->with('succes', 'Вихід успішний!');
    }

    public function showResetPassword()
    {
        return view('user.buyer.forgotPassword');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $status=Password::broker('buyers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($buyer, string $password){
                $buyer->forceFill([
                    'password'=>Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $buyer->save();
                event(new PasswordReset($buyer));
            }
        );
        //dd($status.'==='.Password::PasswordReset);
        return $status === Password::PasswordReset
            ? redirect()->route('checkout.user')->with('succes', __($status))
            : back()->withErrors(['email'=> [__($status)]]);
    }

    public function updateBuyer(UpdateBuyerRequest $request, string $idBuyer)
    {
        if (Auth::guard('buyers')->user()->idBuyer==$idBuyer){
            $buyer=Buyer::find($idBuyer);
            $buyer->number=$request->number;
            if ($buyer->email!=$request->email){
                $buyer->email_verified_at=null;
            }
            $buyer->email=$request->email;
            $buyer->pib=$request->lastName.' '.$request->firstName.' '.$request->middleName;
            $buyer->update();
            return back()->with('succes', 'Данні користувача оновлено!');
        }
        else{
            return back()->withErrors(['errorGuest'=>'Таке добавлення неможливе!']);
        }
    }

    public static function addAddressToDb($idAddress)
    {
        $buyer=Buyer::find(Auth::guard('buyers')->user()->idBuyer);
        $buyer->idAddress=$idAddress;
        $buyer->update();
    }

    public static function addNovaPostToDb($idNovaPost)
    {
        $buyer=Buyer::find(Auth::guard('buyers')->user()->idBuyer);
        $buyer->idNovaPost=$idNovaPost;
        $buyer->update();
    }

    public static function deleteNovaPost()
    {
        $buyer=Auth::guard('buyers')->user();
        $buyer->idNovaPost=null;
        $buyer->update();
    }

    public function authenticationGoogleBuyers()
    {
        $googleBuyer = Socialite::driver('google')->user();
        $url=session('previsionUrl');
        Session::forget('previsionUrl');
        if (session('registration')==true){
            Session::forget('registration');
            $rezult=Buyer::where('email', $googleBuyer->email)->first();
            if (empty($rezult)) {
                self::registrationGoogle($googleBuyer);
            }
            else{
                return redirect()->to($url)->withErrors(['errorGuest'=>'Такий аккаунт вже існує, потрібно залогінитись!']);
            }
        }
        $buyer=Buyer::where('googleId', $googleBuyer->id)->first();
        if ($buyer){
            Auth::guard('buyers')->login($buyer);
            return redirect()->to($url)->with('succes', 'Вхід успішний!');
        }
        else{
            $buyerCheck=Buyer::where('email', $googleBuyer->email)->first();
            //dd($buyerCheck);
            if ($buyerCheck){
                $buyerCheck->googleId=$googleBuyer->id;
                if ($buyerCheck->email_verified_at==null && $googleBuyer->user['email_verified']==true){
                    $buyerCheck->email_verified_at=Carbon::now('Europe/Kyiv')->format('Y-m-d H:i:s');
                }
                $buyerCheck->update();
                Auth::guard('buyers')->login($buyerCheck);
                return redirect()->to($url)->with('succes', 'Вхід успішний!');
            }
            else{
                return redirect()->to($url)->withErrors(['errorGuest'=>'Такого аккаунта неіснує, потрібно зареєструватись!']);
            }
        }
    }

    public static function registrationGoogle($googleBuyer)
    {
        //dd($googleBuyer);
        //dd(session('previsionUrl'));
        $password=Str::random(12);
        $buyer=Buyer::create([
            'googleId'=>$googleBuyer->id,
            'password'=>Hash::make($password),
            'email'=>$googleBuyer->email,
        ]);
        Auth::guard('buyers')->login($buyer);
        Mail::to($buyer->email)->queue(new AccountGoogleCreated($buyer->email, $password));
        $url=session('previsionUrl');
        Session::forget('previsionUrl');
        return redirect()->to($url)->with('succes', 'Реєстрація пройшла успішна!');
    }

    public static function getBuyer($idBuyer)
    {
        $buyer=Buyer::find($idBuyer)->toArray();
        return $buyer;
    }
}
