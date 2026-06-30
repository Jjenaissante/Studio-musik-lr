<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $table = 'studio';
    protected $primaryKey = 'id_studio';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_studio',
        'nama_studio',
        'alamat',
        'no_telp',
        'email',
        'jam_buka',
        'jam_tutup',
        'foto',
    ];

    public function ruangans()
    {
        return $this->hasMany(Ruangan::class, 'id_studio', 'id_studio');
    }
}
