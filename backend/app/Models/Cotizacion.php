<?php

namespace App\Models;

use App\Models\Ciudad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = 'cotizaciones';
    protected $fillable = ['ciudad_id', 'modelo', 'nombre_cliente', 'email', 'celular', 'fecha_solicitud'];

    //Relationship to Ciudad
    public function ciudad() {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }
}
