<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBooking extends Model
{
    protected $table = 'detail_booking';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_booking',
        'total_bayar',
        'bukti_pembayaran',
        'status_pembayaran',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }
}
