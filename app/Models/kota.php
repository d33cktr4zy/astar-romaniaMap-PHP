<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kota extends Model
{
    //
    protected $table = 'kota';

    protected $primaryKey = 'idKota';
    public $timestamps = false;

    protected $fillable = [
        'idKota',
        'namaKota',
    ];

    public function keKota(){
        return $this->hasMany('App\Models\real','idKotaAsal','idKota');
    }

    public function dariKota(){
        return $this->hasMany('App\Models\real','idKotaTujuan','idKota');
    }

    public function hCost(){
        return $this->hasOne('App\Models\heuristic','idKota','idKota');
    }
}
