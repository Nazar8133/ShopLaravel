<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        if (Auth::user()->status==1) {
            return view('admin.employee.register');
        }
        else{
            return redirect()->route('admin.index')->withErrors('Реєстрація користувачів доступна лише адміністрації!');
        }
    }

    public function registrEmplyee(Request $request)
    {
        if (Auth::user()->status==1) {
            if ($request->password != $request->password_confirmation) {
                return redirect()->route('register.show')->withErrors('Паролі неспівпадають, вони повинні бути одинаковими!');
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->status = $request->status;
                $user->email = $request->email;
                $user->password = $request->password;
                $user->save();
                return redirect()->route('admin.index')->with('succes', 'Ви успішно зареєстрували користувача ' . $request->name . ' !');
            }
        }
        else{
            return redirect()->route('admin.index')->withErrors('Реєстрація користувачів доступна лише адміністрації!');
        }
    }

}
