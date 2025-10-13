<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoatbooktimeModel extends Model
{
    protected $table = 'boat_tbl_book_timing';

    protected $fillable = ['time_id', 'boat_id', 'time_from', 'time_to', 'date_book', 'add_date', 'user_id', 'price', 
    'type', 'booktime', 'booked_id'];
}
