<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    protected $table = 'tbl_abonos';
    protected $primaryKey = 'id_abono';
    public $timestamps = false;
    protected $casts = [
        'fecha_pago' => 'datetime',
        'cantidad' => 'decimal:2'
    ];

    public function prestamo(){ return $this->belongsTo(Prestamo::class,'id_prestamo','id_prestamo'); }
}