<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'tbl_grupos';
    protected $primaryKey = 'id_grupo';
    public $timestamps = false;
}