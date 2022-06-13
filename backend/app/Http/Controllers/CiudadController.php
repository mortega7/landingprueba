<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudad;

class CiudadController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByDepartment($id)
    {
        $ciudades = Ciudad::where('departamento_id', $id)->get();
        return $ciudades;
    }
}
