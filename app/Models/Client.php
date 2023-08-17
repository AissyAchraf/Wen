<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'avatar',
    ];

    protected $primaryKey = 'id';
    protected $table = 'clients';
    public $timestamps = false;
}
