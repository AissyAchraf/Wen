<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type_id',
        'start_date',
        'end_date',
        'status',
        'client_id',
        'hotel_id',
        'chalet_id',
        'restaurant_id',
    ];

    protected $primaryKey = 'id';
    protected $table = 'subscriptions';
    public $timestamps = false;
}
