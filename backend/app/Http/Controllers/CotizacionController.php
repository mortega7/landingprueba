<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CotizacionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $codigo = Response::HTTP_BAD_REQUEST;
        $tipo = 'error';

        try {
            $formFields = $request->validate([
                'modelo' => ['required', 'min:3', 'max:255'],
                'nombre_cliente' => ['required', 'regex:/(^[A-Za-z ]+$)+/i', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'celular' => ['required', 'min:7', 'max:10'],
                'ciudad_id' => ['required'],
            ]);

            //Crear Cotizacion y enviar correos
            $codigo = Response::HTTP_OK;
            $cotizacion = Cotizacion::create($formFields);
            $mensaje = 'Cotización registrada exitosamente. ';
            $mensaje .= EnvioCorreoController::send($cotizacion);
            $tipo = 'success';
        } catch (\Exception $error) {
            switch ($error->getCode()) {
                case 0:
                    $codigo = ($error instanceof ValidationException) ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST;
                    $mensaje = $error->getMessage();
                    $tipo = 'error';
                    break;
                case 23000:
                    $codigo = Response::HTTP_OK;
                    $mensaje = 'Ya se ha enviado esta cotización el día de hoy!';
                    $tipo = 'warning';
                    break;
                default:
                    $mensaje = 'Error al crear cotización (Código '.$error->getCode().')';
                    $tipo = 'error';
                    break;
            }
        }

        return new Response(['mensaje' => $mensaje, 'tipo' => $tipo], $codigo);
    }

    /**
     * Se activa si hay algun error de validacion en la cotizacion
     * 
     * @param Illuminate\Contracts\Validation\Validator $validator
     * @throw HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores de validación',
            'data'      => $validator->errors()
        ]));
    }
}
