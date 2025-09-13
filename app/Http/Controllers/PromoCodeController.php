<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\PromoCodeRequest;
use App\Http\Controllers\WatchController;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promoCode=PromoCode::all();
        return view('admin.promoCode.show', compact('promoCode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promoCode.create');
    }

    public function generatePromoCode(Request $request)
    {
        if ($request->has('generate')) {
            $code = '';
            $work = true;
            while ($work) {
                for ($i = 0; $i < 4; $i++) {
                    $code .= rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
                    if ($i != 3) {
                        $code .= '-';
                    }
                }
                $rezult = PromoCode::where('code', $code)->first();
                if (empty($rezult)) {
                    $work = false;
                }
            }
            Session::put('code', $code);
            return back();
        }
        else{
            $request->validate(['promoCode'=>'required|unique:promo_codes,code|size:19|regex:/^\d{4}-\d{4}-\d{4}-\d{4}$/u']);
            Session::put('code', $request->promoCode);
            return  back()->with('succes', 'Промокод збережено!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromoCodeRequest $request)
    {
        if(preg_match('/^\d{4}-\d{4}-\d{4}-\d{4}$/u', session('promoCode'))==1) {
            $promoCode = new PromoCode();
            $promoCode->code = session('promoCode');
            $promoCode->discountValue = $request->discountValue;
            $promoCode->codeAmount=$request->codeAmount;
            $promoCode->dateStart = $request->dateStart;
            $promoCode->dateEnd = $request->dateEnd;
            $promoCode->save();
            Session::forget('promoCode');
            return back()->with('succes', 'Промокод успішно додано!');
        }
        else{
            return back()->withErrors('Неправильний формат промокода!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promoCode=PromoCode::find($id);
        return view('admin.promoCode.edit', compact('promoCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromoCodeRequest $request, string $id)
    {
        $request->validate(['promoCode'=>'required|size:19|regex:/^\d{4}-\d{4}-\d{4}-\d{4}$/u']);
        $promoCode=PromoCode::find($id);
        if ($promoCode->code!=$request->promoCode){
            $promoCode->code=$request->promoCode;
        }
        $promoCode->codeAmount=$request->codeAmount;
        $promoCode->discountValue=$request->discountValue;
        $promoCode->dateStart=$request->dateStart;
        $promoCode->dateEnd=$request->dateEnd;
        $promoCode->update();
        return redirect()->route('promoCode.index')->with('succes', 'Редагування пройшло успішно!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promoCode=PromoCode::find($id);
        $promoCode->delete();
        return redirect()->route('promoCode.index')->with('succes', 'Видалення пройшло успішно!');
    }

    public static function promoCodeCheck($promoCode)
    {
        $promoCodeCheck=PromoCode::where('code', $promoCode)->first();
        return $promoCodeCheck;
    }

    public static function promoCodeUpdate($idPromoCode)
    {
        $promoCode=PromoCode::find($idPromoCode);
        $promoCode->codeAmount=$promoCode->codeAmount-1;
        $promoCode->update();
    }

    public static function getPromoCode($idPromoCode)
    {
        $promoCode=PromoCode::select('code', 'discountValue')->first()->toArray();
        return $promoCode;
    }
}
