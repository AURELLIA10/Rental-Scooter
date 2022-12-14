<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'scooter_id',
        'user_id',
        'transaction_code',
        'name',
        'email',
        'phone',
        'address',
        'identiity_number',
        'image_sim',
        'date_start',
        'date_end',
        'people',
        'transaction_total',
        'transaction_status',
    ];

    // relasi. 1 scooter bisa punya banyak transaksi di hasil postmannya
    public function scooter()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
