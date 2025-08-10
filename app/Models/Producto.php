<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'tbl_productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;
}