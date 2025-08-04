<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['name', 'position', 'user_id'];

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalTransactions()
    {
        return $this->hasMany(MedicalTransaction::class, 'doctor_id');
    }
}