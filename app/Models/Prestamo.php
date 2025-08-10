<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'tbl_prestamos';
    protected $primaryKey = 'id_prestamo';
    public $timestamps = false;
    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_aprovacion' => 'datetime',
        'fecha_entrega_recurso' => 'datetime',
        'cantidad' => 'decimal:2',
    ];

    public function status(){ return $this->belongsTo(StatusPrestamo::class,'id_status_prestamo','id_status_prestamo'); }
    public function producto(){ return $this->belongsTo(Producto::class,'id_producto','id_producto'); }
    public function grupo(){ return $this->belongsTo(Grupo::class,'id_grupo','id_grupo'); }
}