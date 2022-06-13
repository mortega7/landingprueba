<?php

namespace App\Models;

use App\Models\Ciudad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    protected $table = 'departamentos';
    protected $fillable = ['codigo', 'nombre'];

    //Relacion con Ciudad
    public function ciudades() {
        return $this->hasMany(Ciudad::class, 'departamento_id');
    }
}
