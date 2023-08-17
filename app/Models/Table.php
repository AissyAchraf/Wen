<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'number',
        'price',
        'is_available',
        'capacity',
        'photos',
        'restaurent_id'
    ];

    protected $primaryKey = 'id';
    protected $table = 'tables';
    public $timestamps = false;

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
