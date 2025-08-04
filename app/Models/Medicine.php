<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';
    protected $fillable = ['name', 'price', 'stock'];

    public function medicalTransactions()
    {
        return $this->belongsToMany(MedicalTransaction::class, 'medical_transaction_medicines')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
