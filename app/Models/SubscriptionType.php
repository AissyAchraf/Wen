<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'price',
        'duration',
        'included_benefites',
    ];

    protected $primaryKey = 'id';
    protected $table = 'subscription_types';
    public $timestamps = false;
}
