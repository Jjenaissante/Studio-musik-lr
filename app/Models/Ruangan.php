<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ruangan',
        'id_studio',
        'nama_ruangan',
        'kapasitas',
        'tarif_per_jam',
        'status',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class, 'id_studio', 'id_studio');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_ruangan', 'id_ruangan');
    }
}
