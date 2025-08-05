<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $table = 'tbl_user_data';
    protected $primaryKey = 'id_user_data';
    public $timestamps = false;
}