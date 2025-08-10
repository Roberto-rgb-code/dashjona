<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosUsuario extends Model
{
    protected $table = 'tbl_datos_usuario';
    protected $primaryKey = 'id_datos_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario', 'nombre', 'ap_paterno', 'ap_materno', 'telefono_casa',
        'telefono_celular', 'direccion', 'numero_exterior', 'numero_interior',
        'colonia', 'codigo_postal', 'localidad', 'municipio', 'estado',
        'latitud', 'longitud', 'foto_perfil'
    ];
}