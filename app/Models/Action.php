<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['name', 'price'];

    public function medicalTransactions()
    {
        return $this->belongsToMany(MedicalTransaction::class, 'medical_transaction_actions')
                    ->withPivot('price')
                    ->withTimestamps();
    }
}
