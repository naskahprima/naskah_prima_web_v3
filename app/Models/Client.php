<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

     protected $fillable = [
        'nama_lengkap',
        'email',
        'no_whatsapp',
        'institusi',
        'catatan_khusus',
    ];

    public function naskah()
    {
        return $this->hasOne(Naskah::class);
    }
}
