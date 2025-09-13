<?php

namespace App\Http\Controllers;

use App\Http\Requests\WatchRequest;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Models\Watch;
use App\Models\Style;
use App\Models\Gender;
use App\Models\Mechanism;
use App\Models\Brend;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\MechanismController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\BrendController;
use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\WatchUserRequest;

class WatchController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public static function index()
    {
        $watch=Watch::all();
        for ($i=0; $i<count($watch); $i++){
            $photo=Photo::where('idWatch', $watch[$i]['idWatch'])->where('status', 1)->first();
            $mechanism=Mechanism::find($watch[$i]['idMech']);
            if ($photo) {
                $watch[$i]['photo'] = $photo->photo;
            }
            if ($mechanism){
                $watch[$i]['mechanism']=$mechanism->type;
            }
        }
        return view('admin.watch.index', compact('watch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brend=BrendController::showAllBrend();
        $style=StyleController::showAllStyles();
        $mechanism=MechanismController::showAllMechanism();
        $gender=Gender::select('idGender', 'gender')->get();
        return view('admin.watch.create', compact('brend', 'mechanism', 'gender', 'style'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WatchRequest $request)
    {
        $watch=new Watch();
        $watch->idBrend=$request->brend;
        $watch->name=$request->name;
        $watch->idMech=$request->mechanism;
        $watch->idGen=$request->gender;
        $watch->idStyle=$request->style;
        $watch->discription=$request->discription;
        $watch->price=$request->price;
        $watch->kolvo=$request->kolvo;
        $watch->save();
        $id=$watch->idWatch;
        PhotoController::addPhoto($request->file('photo'), $id);
        return redirect()->route('watch.index')->with('succes', 'Добавлення товару пройшло успішно!');
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
        $watch=Watch::find($id);
        $brend=Brend::all();
        $mechanism=Mechanism::all();
        $gender=Gender::all();
        $style=Style::all();
        $photo=Photo::select('idPhoto', 'photo')->where('idWatch', $watch['idWatch'])->get();
        return view('admin.watch.edit', compact('watch', 'brend', 'mechanism', 'gender', 'style', 'photo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WatchRequest $request, string $id)
    {
        $watch=Watch::find($id);
        $watch->idBrend=$request->brend;
        $watch->name=$request->name;
        $watch->idMech=$request->mechanism;
        $watch->idGen=$request->gender;
        $watch->idStyle=$request->style;
        $watch->discription=$request->discription;
        $watch->price=$request->price;
        $watch->kolvo=$request->kolvo;
        $watch->update();
        return redirect()->route('watch.index')->with('succes', 'Редагування годинника пройшло успішно!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PhotoController::destroyAllPhotos($id);
        $watch=Watch::find($id);
        $watch->delete();
        return redirect()->route('watch.index')->with('succes', 'Видалення гидинника пройшло успішно!');
    }

    public function indexUser(WatchUserRequest $request)
    {
        //dd($request);
        $rezult=true;
        $brend=BrendController::showAllBrend();
        $style=StyleController::showAllStyles();
        $mechanism=MechanismController::showAllMechanism();
        $gender=Gender::select('idGender', 'gender')->get();
        if ($request->search){
            $rezult=false;
            $query=Watch::select('photo', 'name', 'watches.idWatch', 'price', 'type', 'kolvo')
                ->join('photos', 'photos.idWatch', '=', 'watches.idWatch')
                ->join('mechanisms', 'idMechanism', '=', 'idMech')
                ->where('status', 1)
                ->where('name', 'like', '%'.$request->search.'%');
        }
        elseif ($request->mechanismFilter || $request->brendFilter || $request->styleFilter || $request->genderFilter || session('mechanismFilter') || session('brendFilter') || session('styleFilter') || session('genderFilter')){
            $rezult=false;
            $query=Watch::select('photo', 'name', 'watches.idWatch', 'price', 'type', 'kolvo')
                ->join('photos', 'photos.idWatch', '=', 'watches.idWatch')
                ->join('mechanisms', 'idMechanism', '=', 'idMech')
                ->where('status', 1);
            if ($request->mechanismFilter || session('mechanismFilter')){
                if (session('mechanismFilter')){
                    if ($request->mechanismFilter) {
                        Session::put('mechanismFilter', $request->mechanismFilter);
                    }
                    $query->whereIn('idMech', session('mechanismFilter'));
                    //Session::forget('mechanismFilter');
                }
                else {
                    Session::put('mechanismFilter', $request->mechanismFilter);
                    $query->whereIn('idMech', $request->mechanismFilter);
                }
            }
            if ($request->brendFilter || session('brendFilter')){
                if (session('brendFilter')){
                    if ($request->brendFilter){
                        Session::put('brendFilter', $request->brendFilter);
                    }
                    $query->whereIn('idBrend', session('brendFilter'));
                }
                else{
                    Session::put('brendFilter', $request->brendFilter);
                    $query->whereIn('idBrend', $request->brendFilter);
                }
            }
            if ($request->styleFilter || session('styleFilter')){
                if (session('styleFilter')){
                    if ($request->styleFilter){
                        Session::put('styleFilter', $request->styleFilter);
                    }
                    $query->whereIn('idStyle', session('styleFilter'));
                }
                else{
                    Session::put('styleFilter', $request->styleFilter);
                    $query->whereIn('idStyle', $request->styleFilter);
                }
            }
            if ($request->genderFilter || session('genderFilter')){
                if (session('genderFilter')){
                    if ($request->genderFilter){
                        Session::put('genderFilter', $request->genderFilter);
                    }
                    $query->whereIn('idGen', session('genderFilter'));
                }
                else{
                    Session::put('genderFilter', $request->genderFilter);
                    $query->whereIn('idGen', $request->genderFilter);
                }
            }

        }
        if ($rezult) {
            $query = Watch::select('photo', 'name', 'watches.idWatch', 'price', 'type', 'kolvo')
                ->join('photos', 'photos.idWatch', '=', 'watches.idWatch')
                ->join('mechanisms', 'idMechanism', '=', 'idMech')
                ->where('photos.status', '=', 1);
        }
        if ($request->priceMin || $request->priceMax || session('priceMin') || session('priceMax')){
            if ($request->priceMin){
                $query->where('price', '>', $request->priceMin);
                Session::put('priceMin', $request->priceMin);
            }
            if ($request->priceMax){
                $query->where('price', '<', $request->priceMax);
                Session::put('priceMax', $request->priceMax);
            }
            if (session('priceMin')){
                $query->where('price', '>', session('priceMin'));
            }
            if (session('priceMax')){
                $query->where('price', '<', session('priceMax'));
            }
        }
        if ($request->sort && $request->direction || session('sortName') && session('typeSort')){
            if (session('sortName')){
                if ($request->sort && $request->direction){
                    Session::put('sortName', $request->sort);
                    Session::put('typeSort', $request->direction);
                }
                $watchIndex = $query->orderBy(session('sortName'), session('typeSort'))->paginate(6);
            }
            else {
                Session::put('sortName', $request->sort);
                Session::put('typeSort', $request->direction);
                $watchIndex = $query->orderBy($request->sort, $request->direction)->paginate(6);
            }
        }
        else{
            $watchIndex=$query->orderBy('watches.created_at', 'desc')->paginate(6);
        }
        //dd($watchIndex);
        return view('user.watch.index', compact('watchIndex', 'brend', 'style', 'mechanism', 'gender'));
    }

    public function showWatch(string $id)
    {
        $watch=Watch::select('name', 'idWatch', 'discription', 'price', 'type', 'style', 'gender', 'brend', 'kolvo')
            ->join('mechanisms', 'idMechanism', '=', 'idMech')
            ->join('genders', 'idGender', '=', 'idGen')
            ->join('brends', 'brends.idBrend', '=', 'watches.idBrend')
            ->join('styles', 'styles.idStyle', '=', 'watches.idStyle')
            ->where('idWatch', $id)
            ->first();
        if (empty($watch)){
            return back()->withErrors('Такого товару неіснує!');
        }
        $photo=PhotoController::showAllPhotoUser($id);
        $rezultCheck=false;
        if (Session::has('basket') && !empty(session('basket'))){
            foreach (session('basket') as $itemSession){
                if ($itemSession['idWatch']==$id){
                    $rezultCheck=true;
                }
            }
        }
        return view('user.watch.show', compact('watch', 'photo', 'rezultCheck'));
    }

    public static function watchBasket($idWatch, $kolvo)
    {
        $watch=Watch::select('watches.idWatch', 'name', 'price', 'photo', 'kolvo as maxKolvo')
            ->join('photos', 'photos.idWatch', '=', 'watches.idWatch')
            ->where('status', 1)
            ->where('watches.idWatch', $idWatch)
            ->get()
            ->toArray();
        $watch[0]['kolvo']=$kolvo;
        return $watch;
    }

    public static function removeDiscountFromWatch()
    {
        $basket=session('basket');
        $totalCost=0;
        for ($i=0; $i<count($basket); $i++){
            $watchPrice=Watch::select('price')->where('idWatch', $basket[$i]['idWatch'])->first();
            $basket[$i]['price']=$watchPrice->price;
            $basket[$i]['activePromo']=false;
            $totalCost +=  $basket[$i]['price'] * $basket[$i]['kolvo'];
        }
        Session::put('basket', $basket);
        Session::put('totalCost', $totalCost);
    }

    public static function checkWatchKolvo($idWatch)
    {
        $watch=Watch::find($idWatch);
        if (empty($watch)){
            return false;
        }
        elseif ($watch->kolvo<=0){
            return false;
        }
        else{
            return true;
        }
    }

    public static function updateWatchKolvo($watch)
    {
        foreach ($watch as $tmpWatch){
            Watch::where('idWatch', $tmpWatch['idWatch'])->update(['kolvo'=>$tmpWatch['maxKolvo']-$tmpWatch['kolvo']]);
        }
    }

}
