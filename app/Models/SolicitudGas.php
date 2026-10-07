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
        'retira_tercero',
        'fecha_modificacion',
        'fecha_entrega',
        'observaciones',
        'costo_total',
        'pdf_tercero'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleSolicitud::class);
    }

}
