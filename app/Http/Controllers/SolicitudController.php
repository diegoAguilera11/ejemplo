<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\ValidationException;



class SolicitudController extends Controller
{
    public function GenerateRequest()
    {
        return view('/cliente/create');
    }


    protected function requestService(Request $request)
    {

        $DateRequest = $request->dateRequest;
        $user = Auth::user();

        $cliente_id = $user->id;


        DB::table('solicituds')->where('id', $cliente_id);
        return redirect()->route('home')->with('password', 'updated');
    }


    public function index()
    {
        $solicituds = Auth::user()->solicitudesCliente()->orderBy('fecha_solicitud')->orderBy('hora_solicitud')->simplePaginate(10);

        return view('cliente.edit')->with('solicituds', $solicituds);
    }

    public function agregarComentario(Request $request, $id)
    {

        $solicitud = Solicitud::where('id', $id)->FirstOrFail();

        $solicitud->comentario = $request->comentario;

        $solicitud->save();

        return redirect('/cliente');
    }



    public function cancelStatusSolicitud($request)
    {
        $solicitud = Solicitud::where('id', $request)->get()->first();
            $solicitud->estado = 'ANULADA';
            $solicitud->save();
            session()->flash('anular', 'La Solicitud fue anulada con exito!');
            return redirect('/cliente');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.create');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitud $solicitud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitud $solicitud)
    {
        //
    }

    public function store(Request $request)
    {

        $date = date($request->fecha_solicitud);
        $time = date($request->hora_solicitud);
        $solicituds = Auth::user()->solicitudesCliente()->get();

        // $request->validate([
        //     'fecha_solicitud' => ['required', 'date', 'regex:'],
        // ]);

        switch ($date) {
            case null:
                throw ValidationException::withMessages(['fecha_solicitud' => 'Debe seleccionar una fecha.']);
                break;

            case ($date < date("Y-m-d")):
                throw ValidationException::withMessages(['fecha_solicitud' => 'Las solicitudes se pueden realizar desde: ' . date("d-m-Y")]);
                break;

            case ($date >= "9999-12-31"):
                throw ValidationException::withMessages(['fecha_solicitud' => 'La fecha indicada no es válida, debe seguir el formato: DD/MM/YYYY.']);
                break;
        }
        if ($time == null) {
            throw ValidationException::withMessages(['hora_solicitud' => 'Debe seleccionar una hora.']);
        }


        foreach ($solicituds as $solicitud) {

            if ($solicitud->fecha_solicitud == $date && $solicitud->estado == "INGRESADA") {
                throw ValidationException::withMessages(['fecha_solicitud' => 'Ya existe solicitud para la fecha:' . $date]);
            }
        }


        Solicitud::create([
            'fecha_solicitud' => $date,
            'hora_solicitud' => $time,
            'estado' => "INGRESADA",
            'cliente_id' => Auth::user()->id,
        ]);

        session()->flash('exito', 'El servicio fue solicitado con exito!');
        return redirect(route('home'));
    }
}
