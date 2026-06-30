<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_user',
        'email',
        'no_hp',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_user', 'id_user');
    }
}
