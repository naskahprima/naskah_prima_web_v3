<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTerbit extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_jurnal_id',
        'bulan',
        'volume_issue',
        'catatan',
    ];

    public function mitraJurnal()
    {
        return $this->belongsTo(MitraJurnal::class);
    }
}
