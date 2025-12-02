<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Naskah extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_naskah',
        'client_id',
        'mitra_jurnal_id',
        'bidang_topik',
        'tanggal_masuk',
        'target_bulan_publish',
        'status',
        'tanggal_published',
        'biaya_dibayar',
        'file_naskah',
        'catatan_progress',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_published' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function mitraJurnal()
    {
        return $this->belongsTo(MitraJurnal::class);
    }
}
