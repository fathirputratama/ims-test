<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = ['patient_id', 'user_id', 'registration_date', 'status'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'dokter');
    }

    public function medicalTransaction()
    {
        return $this->hasOne(MedicalTransaction::class);
    }

     protected $casts = [
        'registration_date' => 'datetime:Y-m-d',
    ];
}
