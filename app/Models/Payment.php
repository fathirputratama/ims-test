<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['medical_transaction_id', 'amount_paid', 'change', 'payment_date', 'status'];

    public function medicalTransaction()
    {
        return $this->belongsTo(MedicalTransaction::class);
    }

    protected $casts = [
    'payment_date' => 'datetime',
];
}
