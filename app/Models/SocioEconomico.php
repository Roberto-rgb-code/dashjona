<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioEconomico extends Model
{
    protected $table = 'tbl_socio_economico';
    protected $primaryKey = 'id_socio_economico';
    public $timestamps = false;

    protected $fillable = ['id_usuario', 'id_promotora', 'estatus', 'fecha_registro', 'fecha_actualizacion'];

    public function usuario()
    {
        return $this->belongsTo(DatosUsuario::class, 'id_usuario');
    }
}