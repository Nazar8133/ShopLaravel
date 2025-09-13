<?php

namespace App\Http\Controllers;

use App\Models\NovaPostAddresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BuyerController;
use Illuminate\Support\Facades\Cache;

class NovaPostController extends Controller
{
    public function getCitiesNp(Request $request)
    {
        $request->validate([
            'searchCity'=>['required', 'min:3', 'max:50', 'regex:/^([а-яА-ЯІіЇїЄєҐґ():.,\-\'\s])+/u']
        ], ['searchCity.regex'=>'Назва міста може складатись лише з українських літер!']);
        $apiUrl='https://api.novaposhta.ua/v2.0/json/getCities';
        $data=[
            'apiKey'=>env('NP_API_KEY'),
            'modelName'=>'AddressGeneral',
            'calledMethod'=>'getCities',
            'methodProperties'=>[
                'Page'=>'1',
                'FindByString'=>$request->searchCity,
                'Limit'=>'15'
            ]];
        $rezult=Http::retry(3, 500)->timeout(5)->post($apiUrl, $data);
        //dd($rezult->json());
        if (!empty($rezult->json()['data'])){
            foreach ($rezult->json()['data'] as $tmpRezult){
                if ($tmpRezult['PreventEntryNewStreetsUser']==0){
                    $citiesNp[$tmpRezult['Ref']]=$tmpRezult['SettlementTypeDescription'].' '.$tmpRezult['Description'].', '.$tmpRezult['AreaDescription'].' обл.';
                }
            }
            Session::put('searchCity', $citiesNp);
            return back()->with('openSearchCity', true);
        }
        else{
            return back()->withErrors(['errorNp'=>'Щось пішло не так, можливо такого міста не існує!']);
        }
    }

    public function getWarehousesNp(Request $request)
    {
        $request->validate([
            'knopkaCity'=>['required', 'min:3', 'max:150', 'regex:/^([а-яА-ЯІіЇїЄєҐґ():.,\-\'\s])+/u'],
            'cityRef'=>['required', 'size:36', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i']
        ],  ['knopkaCity.regex'=>'Назва відділення може складатись лише з українських літер, і деяких символів!',
             'cityRef.regex'=>'Невірний формат ref міста!']);
        $apiUrl='https://api.novaposhta.ua/v2.0/json/getWarehouses';
        $date=[
            'apiKey'=>env('NP_API_KEY'),
            'modelName'=>'AddressGeneral',
            'calledMethod'=>'getWarehouses',
            'methodProperties'=>[
                'CityRef'=>$request->cityRef,
                'Page'=>'1',
                'Limit'=>'15'
            ]
        ];
        Session::put('selectCity', $request->knopkaCity);
        Session::put('selectCityRef', $request->cityRef);
        Session::forget('selectWarehouses');
        $rezult=Http::retry(3, 500)->timeout(5)->post($apiUrl, $date);
        //dd($rezult->json());
        if (!empty($rezult->json()['data'])){
            foreach ($rezult->json()['data'] as $tmpRezult){
                $warehouses[]=$tmpRezult['Description'];
            }
            Session::put('warehouses', $warehouses);
            return back()->with('openSearchWarehouses', true);
        }
        else{
            //dd($rezult->json());
            return back()->withErrors(['errorNp'=>'Щось пішло не так, можливо такого відділення не існує!']);
        }
    }

    public function searchWarehousesNp(Request $request)
    {
        $request->validate([
            'searchWarehouses'=>['required', 'min:1', 'max:50', 'regex:/^([а-яА-ЯІіЇїЄєҐґ()0-9№:.,\-\'\s])+/u']
        ],  ['searchWarehouses.regex'=>'Назва відділення чи поштомата може складатись лише з українських літер!']);
        $apiUrl='https://api.novaposhta.ua/v2.0/json/getWarehouses';
        $date=[
            'apiKey'=>env('NP_API_KEY'),
            'modelName'=>'AddressGeneral',
            'calledMethod'=>'getWarehouses',
            'methodProperties'=>[
                'FindByString'=>$request->searchWarehouses,
                'CityRef'=>session('selectCityRef'),
                'Page'=>'1',
                'Limit'=>'15'
            ]
        ];
        $rezult=Http::retry(3, 500)->timeout(5)->post($apiUrl, $date);
        if (!empty($rezult->json()['data'])){
            foreach ($rezult->json()['data'] as $tmpRezult){
                $warehouses[]=$tmpRezult['Description'];
            }
            Session::put('warehouses', $warehouses);
            return back()->with('openSearchWarehouses', true);
        }
        else{
            return back()->withErrors(['errorNp'=>'Щось пішло не так, можливо такого відділення не існує!']);
        }
    }

    public function addAddressNp(Request $request)
    {
        Session::put('selectWarehouses', $request->warehouse);
        $novaPostAddress=new NovaPostAddresses();
        $novaPostAddress->cityRef=session('selectCityRef');
        $novaPostAddress->city=session('selectCity');
        $novaPostAddress->warehouse=$request->warehouse;
        $novaPostAddress->save();
        BuyerController::addNovaPostToDb($novaPostAddress->idNovaPost);
        return back();
    }

    public function updateAddressNp(Request $request, string $idNovaPost)
    {
        if ($idNovaPost!=Auth::guard('buyers')->user()->idNovaPost){
            return back()->with('succes', 'Щось не так!');
        }
        else{
            Session::put('selectWarehouses', $request->warehouse);
            $novaPostAddress=NovaPostAddresses::find($idNovaPost);
            $novaPostAddress->cityRef=session('selectCityRef');
            $novaPostAddress->city=session('selectCity');
            $novaPostAddress->warehouse=$request->warehouse;
            $novaPostAddress->update();
            return back();
        }
    }

    public static function getNovaPostAddressById($idNovaPost)
    {
        $addressNovaPost=NovaPostAddresses::find($idNovaPost);
        $apiUrl='https://api.novaposhta.ua/v2.0/json/getWarehouses';
        $date=[
            'apiKey'=>env('NP_API_KEY'),
            'modelName'=>'AddressGeneral',
            'calledMethod'=>'getWarehouses',
            'methodProperties'=>[
                'CityRef'=>$addressNovaPost->cityRef,
                'Page'=>'1',
                'Limit'=>'15'
            ]
        ];
        $rezult=Http::retry(3, 500)->timeout(10)->post($apiUrl, $date);
        //dd($rezult->json());
        if (!empty($rezult->json()['data'])){
            $warehouses=[];
            foreach ($rezult->json()['data'] as $tmpRezult){
                $warehouses[]=$tmpRezult['Description'];
            }
            Session::put('warehouses', $warehouses);
            Session::put('selectCity', $addressNovaPost->city);
            Session::put('selectCityRef', $addressNovaPost->cityRef);
            Session::put('selectWarehouses', $addressNovaPost->warehouse);
            return true;
        }
        else{
            BuyerController::deleteNovaPost();
            $addressNovaPost->delete();
            return false;
        }
    }

    public static function getBuyerNovaPostAddress($idNovaPost)
    {
        $addressNovaPost=NovaPostAddresses::find($idNovaPost);
        return $addressNovaPost;
    }

    /*
    public static function updateNovaPostCities()
    {
        return Cache::remember('novaPostCities', now()->addHours(2), function (){
            $apiUrl='https://api.novaposhta.ua/v2.0/json/getCities';
            $data=[
                'apiKey'=>env('NP_API_KEY'),
                'modelName'=>'AddressGeneral',
                'calledMethod'=>'getCities',
                'methodProperties'=>(object)[
                ]];
            $rezult=Http::timeout(10)->retry(3, 1000)->post($apiUrl, $data);
            return $rezult->json()['data'];
        });
    }

    public function addNovaPostToDb()
    {
        set_time_limit(0);
        $cities=self::updateNovaPostCities();
        foreach ($cities as $city) {
            $response = Http::retry(3, 200)->timeout(10)->post('https://api.novaposhta.ua/v2.0/json/getWarehouses', [
                'apiKey' => env('NP_API_KEY'),
                'modelName' => 'AddressGeneral',
                'calledMethod' => 'getWarehouses',
                'methodProperties' => ['CityRef' => $city['Ref'], 'Limit' => '1'],
            ]);

            $warehouses = $response->json()['data'] ?? [];

            $allWarehouses[$city['Description']] = $warehouses;
        }
        dd($allWarehouses);
    }
    */

}
