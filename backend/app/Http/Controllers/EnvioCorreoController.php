<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\EnvioCorreo;
use App\Models\Cotizacion;
use Illuminate\Http\Response;

class EnvioCorreoController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public static function send(Cotizacion $cotizacion)
    {
        try {
            $mailData = [
                'titulo' => 'Solicitud de Cotización',
                'cotizacion' => $cotizacion
            ];
      
            Mail::send(new EnvioCorreo($mailData));
            return 'Se ha enviado el correo a nuestros asesores!';
        } catch (\Exception $exception) {
            return 'No se ha enviado el correo: '.$exception->getMessage();
        }
    }
}
