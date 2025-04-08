<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrendRequest;
use Illuminate\Http\Request;
use App\Models\Brend;

class BrendController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brend=Brend::all();
        return view('admin.brend.show', compact('brend'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brend.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrendRequest $request)
    {
        $brend=new Brend();
        $brend->brend=$request->brend;
        $brend->save();
        return redirect()->route('brend.create')->with('succes', 'Добавлення бренду пройшло успішно!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brend=Brend::find($id);
        return view('admin.brend.edit', compact('brend'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrendRequest $request, string $id)
    {
        $brend=Brend::find($id);
        $brend->brend=$request->brend;
        $brend->updated_at=now();
        $brend->update();
        return redirect()->route('brend.index')->with('succes', 'Бренд успішно відредаговано!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brend=Brend::find($id);
        $brend->delete();
        return redirect()->route('brend.index')->with('succes', 'Бренд успішно видалено!');
    }
}
