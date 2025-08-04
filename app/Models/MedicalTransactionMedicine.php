<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalTransactionMedicine extends Model
{
    protected $fillable = ['medical_transaction_id', 'medicine_id', 'quantity', 'price'];

    public function medicalTransaction()
    {
        return $this->belongsTo(MedicalTransaction::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
}
