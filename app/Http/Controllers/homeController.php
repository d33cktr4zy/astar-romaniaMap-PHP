<?php

namespace App\Http\Controllers;

use App\Models\kota;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class homeController extends Controller
{
    //
    public function index(){
        $kota = kota::all();

        return view('home',['kota'=>$kota]);
    }

    public function updateBiaya(request $request){
        foreach($request->h as $k=>$v){
            \App\Models\heuristic::find($k)->update(['hCost' => $v]);
        }

        $kota = kota::all();

        return view('home', ['kota' => $kota]);
//        dd($request->h);
    }

    public function findPath(request $request)
    {
        ini_set('max_execution_time', 600);
        $asal = new \app\astar\node((int)$request->asal, 'startNode');
        $tujuan = new \app\astar\node((int)$request->tujuan, 'finalNode');

        $pathfinder = new \app\astar\pathFinder($asal, $tujuan);
        $res =$pathfinder->findPath();

        return $res;
        dd($pathfinder->pathfinder($asal,$tujuan));
        dd($request);
    }
}
