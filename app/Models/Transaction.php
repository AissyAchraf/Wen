<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Mail\ReservationConfirmationMail;
use App\Models\Room;
use App\Models\Chalet;
use App\Models\Table;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'cust_name',
        'cust_email',
        'card_num',
        'card_exp_month',
        'card_exp_year',
        'property_type',
        'property_id',
        'price_currency',
        'paid_amount',
        'unit_price',
        'txn_id',
        'payment_status',
        'created',
        'modified'
    ];

    protected $primaryKey = 'id';
    protected $table = 'transactions';
    public $timestamps = false;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public static function boot() {
  
        parent::boot();
  
        static::created(function ($item) {
            if($item->payment_status != "succeeded") {
                return ;
            }
            $email = $item->cust_email;
            if($item->property_type == "Room") {
                $room = Room::find($item->property_id);
                $item->property_data = $room;
            }else if($item->property_type == "Chalet") {
                $chalet = Chalet::find($item->property_id);
                $item->property_data = $chalet;
            }
            Mail::to($email)->send(new ReservationConfirmationMail($item));
        });
    }
}
