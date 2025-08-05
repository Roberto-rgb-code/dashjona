<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LoanProspect extends Model
{
    protected $table = 'loan_prospects';
    protected $primaryKey = 'id_loan_prospect';
    public $timestamps = false;
}