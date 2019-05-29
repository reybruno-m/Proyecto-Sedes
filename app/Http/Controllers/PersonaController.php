<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Persona;
use App\User;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use PDF;

class PersonaController extends Controller
{
    public function seleccionarCategoria(){
        $cat = Categoria::pluck('descripcion','id');
        return view('inicio', compact($cat));
    }

    public function registrarPersona(Request $request){
        $persona = Persona::where('dni', $request->dni)->get();
        $edadusuario = Persona::validarEdad($request->edad);

        if($persona->count() == 0 ) 
        {
            $persona = Persona::where('email', $request->email)->get();

            if($persona->count() == 0 ) 
            {
                $persona = new Persona;
                $persona->dni = $request->dni;
                $persona->nombre = $request->nombre;
                $persona->apellido = $request->apellido;
                $nivel = $request->optradio;

                if($nivel == 'otro'){
                    $nivel = $request->otro;
                }

                $persona->nivelEjerce = $nivel;
                $persona->email = $request->email;

                if($edadusuario >= env('EDAD_LIMITE')){
                    $personas->edad = $request->edad;
                }else{
                    Session::flash('mensaje_edad', "El usuario debe ser mayor de ".env('EDAD_LIMITE')." años"); 
                    
                    if(\Auth::guest()){
                        return redirect ('registro'); 
                    }else{
                        return redirect ('home');
                    }
                }

                $persona->telefono = $request->telefono;
                $persona->areaConocimiento = $request->areaCon;
                $persona->ciudadProcedencia = $request->ciudadP;
                $persona->estudianteActual = $request->estudianteActual;

                if(\Auth::guest()){
                    $persona->administrador = 0;
                }else{
                    $persona->administrador = 1;
                }

                $persona->categoria_id = $request->categorias;
                $persona->save();

                $email = $request->email;
                $nombre = $request->nombre;

                try { /*
                    \Mail::send('emails.confirmation_code', ['email' => $email, 'nombre' => $nombre], function ($m) use ($email,$nombre) {
                    $m->from('formulario@sedessapientiae.com', 'Sedes Sapientiae');
                    $m->to($email, $nombre)->subject('Asunto del mensaje');
                    });*/
                }catch (Exception $e){ 
                    abort(303);
                }
                
                return redirect('home');
            }else{
                Session::flash('mensaje_correo', "El correo ya se encuentra registrado"); 
                return redirect ('registro');
            }
        }else{
            Session::flash('mensaje_dni', "El usuario ya se encuentra registrado"); 
            return redirect ('registro');
        }
    }

    public function generarPDF(Request $request){
        $personas = Persona::where('apellido', $request->filtrar)->get();
        $pdf = PDF::loadView('pdfPersonas', compact('personas'));
        return $pdf->download('listadoPersonas.pdf');
    }

    public function exportar(){
        return view ('exportarPdf');
    }
}
