<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'reservation_id',
        'comment',
        'star_rating',
        'status',
        'room_id',
        'hotel_id',
        'restaurent_id',
        'chalet_id',
        'dish_id',
    ];

    protected $primaryKey = 'id';
    protected $table = 'reviews';
    public $timestamps = true;
}
