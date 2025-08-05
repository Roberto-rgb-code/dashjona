<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    protected $table = 'payment_schedule';
    protected $primaryKey = 'id_payment';
    public $timestamps = false;
}