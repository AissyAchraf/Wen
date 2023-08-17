<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'photo',
        'menu_id',
    ];

    protected $primaryKey = 'id';
    protected $table = 'dishes';
    public $timestamps = false;
}
