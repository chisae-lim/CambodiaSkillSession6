<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    use HasFactory;
    protected $table = 'itemprices';
    protected $primaryKey = 'ID';

    function booking_details()
    {
        return $this->hasMany(BookingDetail::class, 'ItemPriceID');
    }
    function item(){
        return $this->belongsTo(Item::class,'ItemID');
    }
}
