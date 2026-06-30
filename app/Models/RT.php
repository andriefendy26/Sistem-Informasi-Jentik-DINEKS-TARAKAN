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
        'name'
    ];

    public function Kelurahan ()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }
}
