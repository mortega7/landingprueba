<?php

namespace App\Models;

use App\Models\Departamento;
use App\Models\Cotizacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    protected $table = 'ciudades';
    protected $fillable = ['departamento_id', 'codigo', 'nombre'];

    //Relacion con Departamento
    public function departamento() {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    //Relacion con Cotizacion
    public function cotizaciones() {
        return $this->hasMany(Cotizacion::class, 'ciudad_id');
    }
}
