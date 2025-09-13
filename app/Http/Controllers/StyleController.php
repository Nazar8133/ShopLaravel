<?php

namespace App\Http\Controllers;

use App\Http\Requests\StyleRequest;
use Illuminate\Http\Request;
use App\Models\Style;

class StyleController extends Controller
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
        $style=Style::all();
        return view('admin.style.show', compact('style'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.style.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StyleRequest $request)
    {
        $style=new Style();
        $style->style=$request->style;
        $style->save();
        return redirect()->route('style.create')->with('succes', 'Додання стилю пройшло успішно!');
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
        $style=Style::find($id);
        return view('admin.style.edit', compact('style'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StyleRequest $request, string $id)
    {
        $style=Style::find($id);
        $style->style=$request->style;
        $style->update();
        return redirect()->route('style.index')->with('succes', 'Редагування пройшло успішно!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $style=Style::find($id);
        $style->delete();
        return redirect()->route('style.index')->with('succes', 'Видалення пройшло успішно!');
    }

    public static function showAllStyles()
    {
        $style=Style::select('idStyle', 'style')->get();
        return $style;
    }
}
