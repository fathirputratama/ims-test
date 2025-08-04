<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalTransactionAction extends Model
{
   protected $fillable = ['medical_transaction_id', 'action_id', 'price'];

    public function medicalTransaction()
    {
        return $this->belongsTo(MedicalTransaction::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
