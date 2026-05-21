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
        'foto',
    ];

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'id_studio', 'id_studio');
    }
}
