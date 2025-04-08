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
use Illuminate\Support\Facades\Storage;

class WatchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $brend=Brend::all();
        $mechanism=Mechanism::all();
        $gender=Gender::all();
        $style=Style::all();
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
}
