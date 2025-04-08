<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mechanism;
use App\Http\Requests\MechanismRequest;

class MechanismController extends Controller
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
        $mechanism=Mechanism::all();
        return view('admin.mechanism.show', compact('mechanism'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mechanism.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MechanismRequest $request)
    {
        $mechanism=new Mechanism();
        $mechanism->type=$request->type;
        $mechanism->save();
        return redirect()->route('mechanism.create')->with('succes', 'Додання типу пройшло успішно!');
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
        $mechanism=Mechanism::find($id);
        return view('admin.mechanism.edit', compact('mechanism'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MechanismRequest $request, string $id)
    {
        $mechanism=Mechanism::find($id);
        $mechanism->type=$request->type;
        $mechanism->updated_at=now();
        $mechanism->update();
        return redirect()->route('mechanism.index')->with('succes', 'Редагування пройшло успішно!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mechanism=Mechanism::find($id);
        $mechanism->delete();
        return redirect()->route('mechanism.index')->with('succes', 'Видалення пройшло успішно!');
    }
}
