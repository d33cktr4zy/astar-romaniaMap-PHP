<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class real extends Model
{
    //
    protected $table = 'real';
    protected $primaryKey = null;

    public $timestamps = false;

    protected $fillable = [
        'idKotaAsal',
        'idKotaTujuan',
        'gCost',
    ];

    public function namaKotaAsal(){
        return $this->belongsTo('App\Models\kota','idKotaAsal','idKota');
    }

    public function namaKotaTujuan(){
        return $this->belongsTo('App\Models\kota','idKotaTujuan','idKota');
    }

}
