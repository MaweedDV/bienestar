<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValesDeGas extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'valor',
        'modificadoPor',
        'fechaModificacion',
    ];
}
