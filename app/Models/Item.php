<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $primaryKey = 'ID';


    function area()
    {
        return $this->belongsTo(Area::class, 'AreaID');
    }

    function prices()
    {
        return $this->hasMany(ItemPrice::class, 'ItemID');
    }

    function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

}
