<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'client_id',
        'start_date',
        'end_date',
        'amount',
        'online_payement',
        'status',
        'room_id',
        'table_id',
        'chalet_id',
    ];

    protected $primaryKey = 'id';
    protected $table = 'reservations';
    public $timestamps = false;
}
