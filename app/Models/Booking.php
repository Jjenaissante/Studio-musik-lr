<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id_booking';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_booking',
        'id_user',
        'id_ruangan',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'durasi',
        'status_booking',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function detail()
    {
        return $this->hasOne(DetailBooking::class, 'id_booking', 'id_booking');
    }
}
