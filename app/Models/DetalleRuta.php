<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetalleRuta extends Model
{
    protected $table = 'tbl_detalle_ruta';
    protected $primaryKey = 'id_detalle_ruta';
    public $timestamps = false;
    protected $fillable = ['latitud','longitud'];
}