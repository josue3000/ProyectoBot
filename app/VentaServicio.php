<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaServicio extends Model
{
    protected $table = 'venta_servicio';
    protected $primaryKey = 'id_venta';
    public $timestamps = false;

    protected $filleable =[
        'id_cliente',
        'equipo',
        'diagnostico',
        'categoria_servicio',
        'tipo_comprobante',
        'num_autorizacion',
        'num_factura',
        'tecnico',
        'fecha_hora',
        'fecha_actual',
        'importe_total',
        'total_servicio',
        'total_repuestos',
        'debito_fiscal',
        'estado_servicio',
        'estado_pago',
        'codigo',
        'condicion',
        'diagnosticoTecnico',
        'notas'

    ];

    protected $guarded = [

    ];
}
