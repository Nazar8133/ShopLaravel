<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeliveryAddressRequest;
use App\Models\Address;
use App\Http\Controllers\BuyerController;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function addDeliveryAddress(DeliveryAddressRequest $request)
    {
        $deliveryAddress=new Address();
        $deliveryAddress->region=$request->region;
        $deliveryAddress->city=$request->city;
        $deliveryAddress->street=$request->street;
        $deliveryAddress->houseNumber=$request->houseNumber;
        $deliveryAddress->apartmentNumber=$request->apartmentNumber;
        $deliveryAddress->save();
        BuyerController::addAddressToDb($deliveryAddress->idAddress);
        return back()->with('succes', 'Адресу успішно добавлено!');
    }

    public function updateDeliveryAddress(DeliveryAddressRequest $request, string $idAddress)
    {
        if ($idAddress==Auth::guard('buyers')->user()->idAddress) {
            $deliveryAddress = Address::find($idAddress);
            $deliveryAddress->region = $request->region;
            $deliveryAddress->city = $request->city;
            $deliveryAddress->street = $request->street;
            $deliveryAddress->houseNumber = $request->houseNumber;
            $deliveryAddress->apartmentNumber = $request->apartmentNumber;
            $deliveryAddress->update();
            return back()->with('succes', 'Адреса успішно відредагована!');
        }
        else{
            return back()->withErrors(['errorGuest'=>'Таке редагування неможливе!']);
        }
    }

    public static function getDeliveryAddressById($idAddress)
    {
        $address=Address::find($idAddress);
        return $address;
    }
}
