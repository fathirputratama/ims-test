<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'user_id',
        'total_cost',
        'payment_status',
        'notes',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'dokter');
    }

    public function actions()
    {
        return $this->belongsToMany(Action::class, 'medical_transaction_actions')
                  ->withPivot('price')
                  ->withTimestamps();
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medical_transaction_medicines')
                  ->withPivot('quantity', 'price')
                  ->withTimestamps();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}