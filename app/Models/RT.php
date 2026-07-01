<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RT extends Model
{
    //
    use HasFactory;

    protected $table = 'rt';

    protected $fillable = [
        'name',
        'id_kelurahan'
    ];

    public function Kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }

      public function abj()   // added — inverse relation, useful for per-RT recap export
    {
        return $this->hasMany(abj::class, 'id_rt');
    }
}
