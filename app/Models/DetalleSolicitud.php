<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSolicitud extends Model
{
    protected $fillable = [
        'id_tipo_gas',
        'cantidad',
        'valor_unitario',
        'valor_total',
        'solicitud_gas_id'
    ];

    public function solicitudGas()
    {
        return $this->belongsTo(SolicitudGas::class);
    }

    public function tipoGas()
    {
        return $this->belongsTo(ValesDeGas::class, 'id_tipo_gas');
    }
}
