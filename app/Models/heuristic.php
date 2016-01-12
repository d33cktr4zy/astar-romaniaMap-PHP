<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class heuristic extends Model
{
    //
    protected $table = 'heuristic';
    protected $primaryKey = 'idKota';

    public $timestamps = false;

    protected $fillable = [
        'idKota',
        'hCost',
    ];

    public function kota()
    {
        return $this->belongsTo('App\Models\kota','idKota','idKota');
    }
}
