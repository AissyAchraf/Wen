<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Facility;

class Hotel extends Facility
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'description',
        'photos',
        'stars',
        'roomsCount',
        'amenities',
        'room_service',
        'user_manager',
        'latitude',
        'longitude',
        'status',
    ];

    protected $primaryKey = 'id';
    protected $table = 'hotels';
    public $timestamps = false;
}
