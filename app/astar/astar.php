<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 12/5/2015
 * Time: 15:39 PM
 */

namespace app\astar;


/**
 * Class astar
 * @package app\astar
 */
class astar
{
    public $closed;
    public $opened;
    public $start;
    public $end;
    public $nextNodeID;
    public $currentGCost;
    public $currentEval;
    public $fValue;

    /**
     * @param $yangdibuang
     * @return array
     */
    public function removeClosed($yangdibuang){
        $this->closed = array_diff($this->closed, [$yangdibuang]);

        return $this->closed;
    }

    /**
     * @param $yangditambah
     * @return array
     */
    public function addClosed($yangditambah){
        $this->closed[] = $yangditambah;

        return $this->closed;
    }

    /**
     * @param $yangditambah
     * @return array
     */
    public function addOpened($yangditambah){
        if(null !== $this->opened){
            //jika opened array tidak kosong,
            if(!array_search($yangditambah, $this->opened)){
                //maka lakukan array search apakah $yangditambah sudah ada.
                //jika belum ada, tambakan data
                $this->opened[] = $yangditambah;
            }//jika tidak tidak usah lakukan apa-apa
        }else {
            //jika opened array kosong, langsung tambahkan
            $this->opened[] = $yangditambah;
        }
            echo 'adding '. $yangditambah . ' ke opened list' . PHP_EOL;
        return $this->opened;
    }

    /**
     * @param $yangdibuang
     * @return array
     * -----------------------------
     * membuang isi array opened dengan id kota $yangdibuang
     */
    public function removeOpened($yangdibuang){
        $this->opened = array_diff($this->opened, [$yangdibuang]);

        return $this->opened;
    }

    /**
     * @param $kota
     */
    public function getNextNodeID($kota){
        echo 'getting NextNodeID of '.$kota.PHP_EOL ;
        $node = \App\Models\kota::find($kota);
        //clean the nextNode Array
        unset($this->nextNodeID);

        foreach($node->keKota as $nextNode){
            $this->nextNodeID[] = $nextNode->idKotaTujuan;
            if(!array_search($nextNode->idKotaTujuan,$this->opened)) {
                echo 'id next node = '. $nextNode->idKotaTujuan .PHP_EOL;
                $this->addOpened($nextNode->idKotaTujuan);
            }else{echo 'not adding to open node' . PHP_EOL; break;};
            if(array_search($nextNode->idKotatujuan,$this->opened)){
                //recalculating f
                echo 'recalculating f for ' .$nextNode->idKotaTujuan.PHP_EOL;
                break;
                $this->hitungBiaya();
            }
        }
    }

    /**
     * @param $kota
     */
    public function openNode($kota){
        //add open node to the opened array
        $this->addOpened($kota);

        //set currrentEval to $kota
        $this->currentEval = $kota;

        //get the next available node id
        $this->getNextNodeID($kota);
    }

    public function closeNode($kota){
        $this->hitungBiaya();
        //pindahkan $kota dari opened ke Closed array
        $this->removeOpened($kota);
        $this->addClosed($kota);

        //remove nilai f yang terminimum dari kota minimum
        unset($this->fValue[$kota]);
        $this->getBestG();


    }

    public function hitungBiaya(){
        //menghitung fValue dari kota yang dibuka
        //
        if(null === $this->currentGCost){
            $this->currentGCost = 0;
        }

        //counting fValue
        foreach($this->nextNodeID as $next){
            echo 'calc f of ' . $next . PHP_EOL;
            $dest = \App\Models\kota::find($next);
            $gcost = \App\Models\real::where('idKotaTujuan',$next)->where('idKotaAsal',$this->currentEval)->pluck('gCost');
            $hcost = $dest->hCost->hCost;
            $this->fValue[$next] = ($this->currentGCost + $gcost) + $hcost;
        }
    }

    public function getMinF(){
        if(null !== $this->fValue){
            $bestNode = array_search(min($this->fValue), $this->fValue);
        }
        return $bestNode;
    }

    public function removeFValue($key){

    }

    public function getBestG(){
        $this->bestNode = $this->getMinF();
        $kotaAsal = $this->currentEval;
        $gcosts = \App\Models\real::where('idKotaAsal', $kotaAsal)->where('idKotaTujuan',$this->bestNode)->pluck('gCost');
        //GCost sekarang + G Cost best node
        $this->currentGCost = $this->currentGCost + $gcosts;
    }

    public function pathfinder($startNode, $endNode){
        //pembersihan data
            $counter = 0;
        //the main pathfinding
        $this->start = $startNode;
        $this->end = $endNode;

        //mulai algoritmanya
        while($this->currentEval !== $this->end){
            //selama node yang sedang di periksa bukan node tujuan,
            if($this->currentGCost = 0 || null === $this->currentGCost){
                //belum ada node yang dikunjungi, so open start
                $this->openNode($this->start);
            } else{
                //path sudah ada
                $this->openNode($this->bestNode);
            }
            $this->closeNode($this->currentEval);
            $counter++;
            echo 'iterasi no. ' . $counter ;
            print_r($this);
            echo PHP_EOL;

        }
        return $this->closed;
    }
}