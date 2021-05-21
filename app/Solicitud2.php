<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Solicitud2 extends Model
{
    protected $table = 'solicitud';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = false;

    protected $filleable =[
        'cliente',
        'descripcion',
        'condicion',
        'estado',
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    protected $guarded = [

    ]; 
}
