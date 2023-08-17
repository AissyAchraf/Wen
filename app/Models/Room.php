<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'number',
        'price',
        'surface',
        'room_type',
        'beds_type',
        'capacity',
        'amenities',
        'is_available',
        'photos',
        'hotel'
    ];

    protected $primaryKey = 'id';
    protected $table = 'rooms';
    public $timestamps = false;

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
