<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'birth_date', 'gender', 'phone', 'address'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    protected $casts = [
    'birth_date' => 'date',
];

}
