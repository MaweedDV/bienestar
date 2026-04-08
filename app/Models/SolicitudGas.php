<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudGas extends Model
{
    protected $fillable = [
        'rut_funcionario',
        'nombre_funcionario',
        'estado',
        'cantidadTotalVales',
        'fecha_solicitud',
        'fecha_modificacion',
        'fecha_entrega',
        'costo_total'
    ];
}
