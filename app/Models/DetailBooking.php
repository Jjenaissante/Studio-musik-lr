<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBooking extends Model
{
    protected $table = 'detail_booking';
    protected $primaryKey = 'id_booking';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_booking',
        'tanggal_pembayaran',
        'total_bayar',
        'metode_pembayaran',
        'status_pembayaran',
        'bukti_pembayaran',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }
}
