<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraJurnal extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jurnal',
        'kategori_sinta',
        'jenis_bidang',
        'link_jurnal',
        'contact_person',
        'no_contact',
        'biaya_publikasi',
        'estimasi_proses_bulan',
        'frekuensi_terbit',
        'status_kerjasama',
        'notes',
    ];

    public function naskahs()
    {
        return $this->hasMany(Naskah::class);
    }

    public function jadwalTerbits()
    {
        return $this->hasMany(JadwalTerbit::class);
    }
}
