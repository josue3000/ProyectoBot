<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = false;

    protected $filleable =[
        'nombre',
        'telefono',
        'email',
        'direccion',
        'problema',
        'condicion',
        'estado',
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    protected $guarded = [

    ]; 
}
