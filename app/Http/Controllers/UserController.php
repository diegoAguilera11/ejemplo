<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function NewPassword()
    {
        return view('/auth/passwords/reset');
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'confirmed', 'min:10'],
            'new_password' => ['required', 'string', 'confirmed', 'min:10'],
            'confirmar_password' => ['required', 'string', 'confirmed', 'min:10'],
        ]);

        $user           = Auth::user();
        
        $userPassword   = $user->password;

        if ($request->password_actual != "") {
            $NewPass   = $request->password;
            $confirPass = $request->confirmar_password;
                if ($NewPass == $confirPass) {
                    
                    
                        $user->password = Hash::make($request->password);
                        $sqlBD = DB::table('users')
                            ->where('id', $user->id)
                            ->update(['password' => $user->password],);
                        return redirect()->back()->with('updateClave', 'La clave fue cambiada correctamente.');

                } else {
                    return redirect()->back()->with('claveIncorrecta', 'Por favor verifique las claves no coinciden.');
                }
            
        } else {

            $name       = $request->name;
            $sqlBDUpdateName = DB::table('users')
                ->where('id', $user->id);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
