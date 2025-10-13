<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoatcharterbookModel extends Model
{
    protected $table = 'boat_charter_book';

    protected $fillable = ['total_price', 'boat_id', 'last_booked', 'user_id', 'add_date', 'status', 'is_skiper', 'is_coupon', 
    'timing_price', 'comment', 'excess_deposit', 'contract', 'referrer_discount', 'user_manager', 'payment_type', 'ifskipper', 
    'user_extrainfo', 'ratingyes', 'seasport_brochure', 'googlesheet', 'googlesheet_paid', 'googlesheet_paid', 'book_type', 'country', 
    'currency', 'discount_type', 'credit_id', 'discount_price', 'membership_id'];
}
