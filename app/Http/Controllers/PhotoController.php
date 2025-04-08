<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoRequest;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function addPhoto($photo, $idWatch)
    {
        $countPhoto=count(Photo::where('idWatch', $idWatch)->get());
        if ($countPhoto==0 && $photo==null){
            $photoDb=new Photo();
            $photoDb->idWatch=$idWatch;
            $photoDb->photo='/storage/photos/noPhoto.jpg';
            $photoDb->status=1;
            $photoDb->save();
        }
        else{
            for($i=0; $i<count($photo); $i++){
                $patch=$photo[$i]->store('photos', 'public');
                $url=Storage::url($patch);
                $photoDb=new Photo();
                $photoDb->idWatch=$idWatch;
                $photoDb->photo=$url;
                if ($i==0 && $countPhoto==0){
                    $photoDb->status=1;
                }
                $photoDb->save();
            }
        }
    }

    public function show(string $id)
    {
        $photo=Photo::find($id);
        if (empty($photo)){
            return view('admin.index');
        }
        return view('admin.photo.edit', compact('photo'));
    }

    public function showAllPhoto(string $idWatch)
    {
        $photo=Photo::where('idWatch', $idWatch)->pluck('photo')->toArray();
        return view('admin.photo.deleteAll', compact('photo', 'idWatch'));
    }

    public function edit(string $id)
    {
        $photo=Photo::find($id);
        $photo1=Photo::where('status', 1)->where('idWatch', $photo->idWatch)->first();
        $photo1->status=0;
        $photo1->update();
        $photo->status=1;
        $photo->updated_at=now();
        $photo->update();
        return redirect()->route('watch.index')->with('succes', 'Фотографію успішно відредаговано!');
    }

    public function showCreatePhoto(string $id)
    {
        $idWatch=$id;
        return view('admin.photo.create', compact('idWatch'));
    }

    public function addPhotoDb(PhotoRequest $request, string $idWatch)
    {
        if ($request->file('photo')){
            PhotoController::addPhoto($request->file('photo'), $idWatch);
            if (count($request->photo)==1) {
                return redirect()->route('watch.edit', ['watch' => $idWatch])->with('succes', 'Добавлення фотографії пройшло успішно!');
            }
            else{
                return redirect()->route('watch.edit', ['watch' => $idWatch])->with('succes', 'Добавлення фотографій пройшло успішно!');
            }
        }
    }

    public static function checkNoPhoto(string $idWatch)
    {
        $rezult=count(Photo::where('idWatch', $idWatch)->get());
        if ($rezult>1){
            return true;
        }
        else{
            return false;
        }
    }

    public function destroy(string $id)
    {
        $photo=Photo::find($id);
        if ($photo->status==1){
            return redirect()->route('photo.show', ['photo'=>$photo->idPhoto])->withErrors('Ця фотогорафія головна, щоб її видалити зробіть головною інше фото!');
        }
        if (basename($photo->photo)!='noPhoto.jpg') {
            Storage::disk('public')->delete('photos/' . basename($photo->photo));
        }
        $photo->delete();
        return redirect()->route('watch.edit', ['watch'=>$photo->idWatch])->with('succes', 'Видалення фотографії пройшло успішно!');
    }

    public static function destroyAll(string $idWatch)
    {
        $photoWatch=Photo::where('idWatch', $idWatch)->pluck('photo')->toArray();
        if (count($photoWatch)<=1 && basename($photoWatch[0])=='noPhoto.jpg'){
            return redirect()->route('watch.edit', ['watch'=>$idWatch])->withErrors('Видалити фотографію noPhoto якщо вона одне неможливе, добавте ще оде фото для видалення!');
        }
        foreach ($photoWatch as $item){
            Storage::disk('public')->delete('photos/'.basename($item));
        }
        Photo::where('idWatch', $idWatch)->delete();
        $newNoPhoto=new Photo();
        $newNoPhoto->idWatch=$idWatch;
        $newNoPhoto->photo='/storage/photos/noPhoto.jpg';
        $newNoPhoto->status=1;
        $newNoPhoto->save();
        return redirect()->route('watch.edit', ['watch'=>$idWatch])->with('succes', 'Видалення фотографій пройшло успішно!');
    }

    public static function destroyAllPhotos(string $idWatch)
    {
        $photo=Photo::where('idWatch', $idWatch)->pluck('photo')->toArray();
        foreach ($photo as $item){
            if (basename($item)!='noPhoto.jpg'){
                Storage::disk('public')->delete('photos/'.basename($item));
            }
        }
        Photo::where('idWatch', $idWatch)->delete();
    }
}
