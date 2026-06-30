<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelurahan extends Model
{
    //
    use HasFactory;

    protected $table = 'kelurahan';

    protected $fillable = [
        'name'
    ];

    public function RT()
    {
        return $this->hasMany(RT::class, 'id_kelurahan');
    }

    public function ABJ()
    {
        return $this->hasMany(abj::class, 'id_kelurahan');
    }
    public function User()
    {
        return $this->hasMany(User::class, 'id_kelurahan');
    }
}
