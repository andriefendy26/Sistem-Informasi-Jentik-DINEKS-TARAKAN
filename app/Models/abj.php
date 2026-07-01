<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class abj extends Model
{
    //
    use HasFactory;

    protected $table = 'abj';

    protected $fillable = [
        'id_user',
        'id_kelurahan',
        'id_rt',
        'name_kepala_keluarga',
        'penampungan_berjentik',
        'penampungan_tidak_berjentik',
        'rumah_berjentik',
        'rumah_tidak_berjentik',
        'tanggal_pemeriksaan',
    ];

    public function Kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
    public function RT()
    {
        return $this->belongsTo(RT::class, 'id_rt');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
