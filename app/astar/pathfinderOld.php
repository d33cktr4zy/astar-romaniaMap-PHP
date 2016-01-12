<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 12/11/2015
 * Time: 14:06 PM
 */

namespace app\astar;


class pathfinderOld
{
    public $start;
    public $end;
    public $opened;
    public $closed;
    public $evalNode; //node yang sedang di hitung
    public $gCostOfBestNode; //gCost dari best node terakhir
    public $currentBestNode; //bestNode terbaik sampai saat ini
    public $successorList; //array dari successor untuk $node
    public $gCostNodes; //array untuk menampung nilai G total dari setiap Nodes
    public $tempNode; //just temp var
    public $FValue; //Array of the calculated FValue of each Nodes. Key is node id
    public $closedF; //Array of FValue of the bestNodes
    public $result;

    public function openNode($node){
        echo 'adding new OpenNode ... (' . $node . ')'. PHP_EOL;
        //buka node
        $this->opened[] = $node;
        echo '<pre> Opened : ' . print_r($this->opened,true);
    }

    public function closeNode($node){
        //menutup node
        echo 'closing node (' . $node . ')... '. PHP_EOL;
        $this->closed[] = $node;
        $this->evalNode = $node;

        //moving the fValue of best node
        $this->closedF[$node] = $this->FValue[$node];
        unset($this->FValue[$node]);

        //hapus dari openNode
        echo '<pre>' . print_r($this->opened,true) . print_r($this->closed,true);
        unset($this->opened[array_search($node,$this->opened)]);

        echo '<pre>' . print_r($this->opened,true). print_r($this->closed,true);

    }

    public function pathfinder($start, $end){
        //init
        $this->opened[] = $start;
        $this->start = $start;
        $this->end = $end;
        $this->gCostOfBestNode = 0 ; //inisial gCostOfBestNode
        $counter = 0;
        echo 'finding the path .... ' . PHP_EOL;
        while(!array_search($end, $this->opened) || null !== $this->opened){
            echo '||++++++++++++++++++++++++++++++++++++++++++++++++++||'.PHP_EOL;
            echo '||++++++++++++++++++++++++++++++++++++++++++++++++++||'.PHP_EOL;
            if(null === $this->opened){
                //failed
            }else{
                echo 'belum sampai tujuan, melanjutkan perjalanan... ' . PHP_EOL;
                $this->currentBestNode = $this->getMinimalF();
                echo 'F Value Now : ' . print_r($this->FValue, true) . PHP_EOL;
                echo 'selecting best node ... ' . PHP_EOL;
                echo print_r($this->currentBestNode, true) . PHP_EOL;
                $this->closeNode($this->currentBestNode); //selecting the best node and remove it from Opened list

                if($this->currentBestNode == $this->end){
                    //success
                    echo print_r($this->closed);
                    $this->getNodeName();
                    return $this->result;
                }else{
                    //bangkitkan sukessor and get the Gcost of each successor
                    echo print_r($this, true);
                    echo 'getting the successor for ' . $this->currentBestNode . ' ....' .PHP_EOL;
                    $this->getSuccessor($this->currentBestNode);

                    //periksa suksessor
                    echo 'checking suksessor ... ' . PHP_EOL;
                    foreach($this->successorList as $key => $value) {
                        $this->cekSuccessor($key);
                    }


                }
            }
            echo 'ending iterasi ('. $counter . ')'.PHP_EOL;
            echo '||-------------------------------------------------||'.PHP_EOL;
            echo '||-------------------------------------------------||'.PHP_EOL;
            $counter++;
        }
        echo 'ending while';

    }

    public function getMinimalF(){
        //finding the minimal F value of the currently Opened list and return the
        //value and the id of the node.
        //just a sanity check

        echo 'Calculating F Value.... ' . PHP_EOL;
        if(null === $this->gCostOfBestNode){
            $this->gCostOfBestNode = 0;
        }

        foreach($this->opened as $id){
            //get the f value of each opened node
            echo 'Calculating F Vale of [' . $id . '] ... '.PHP_EOL;
            $f[$id] = $this->getFValue($id);
            $this->FValue[$id] = $f[$id];
        }

        if(null !== $f) {
            $best = array_keys($f, min($f));

            echo 'NewBestNode G Cost = ' . print_r(min($f), true) . PHP_EOL;

            $this->gCostOfBestNode = min($f);
        }
        return $best[0];

    }

    public function getSuccessor($node){
        echo 'getting successor of ' . $node .PHP_EOL;
        //fungsi membuka semua node yang terhubung dari $node
        //pembersihan
        unset($this->successorList);

        $n = \App\Models\kota::find($node);
//        echo 'value of N = ' . print_r($n->keKota).PHP_EOL;
        foreach($n->keKota as $koneksi){
            $this->successorList[$koneksi->idKotaTujuan] = $this->getTotalG($koneksi->idKotaTujuan);
            echo 'new TotalG for [' . $koneksi->idKotaTujuan . '] = '. $this->successorList[$koneksi->idKotaTujuan]. PHP_EOL;
//            echo $koneksi->idKotaTujuan;
        }

//        foreach($n->dariKota as $koneksi){
//            if(!array_search($koneksi->idKotaAsal,$this->successorList)){
//                $this->successorList[$koneksi->idKotaAsal] = $this->getTotalG($koneksi->idKotaAsal);
//                echo $koneksi->idKotaAsal;
//            }
//        }
        echo 'suksesor yang ditemukan : '. print_r($this->successorList,true);
    }

    public function getTotalG($node){
        //menghitung total GCost sampai titik $node
        //GCost sampai titik node adalah Nilai total G dari $start sampai $node melewati semua $best Node
        //getting partial G
        echo 'menghitung Total GCost for ' . $node . '...'. PHP_EOL;
//        $gcost = \App\Models\real::where('idKotaAsal', $this->currentBestNode)->where('idKotaTujuan', $node)->pluck('gCost');

         $this->tempNode = $node;
        $gcost = \App\Models\real::where(function($qry){$qry->where('idKotaAsal', $this->evalNode)->where('idKotaTujuan', $this->tempNode);})->orWhere(function($p){$p->where('idKotaAsal', $this->tempNode)->where('idKotaTujuan',$this->evalNode);})->pluck('gCost');
        echo 'gcost = ' . $gcost . PHP_EOL;
        $totalG = $this->gCostOfBestNode + $gcost;
        $this->gCostNodes[$node] = $totalG;
        return $totalG;
    }

    public function cekSuccessor($node){
        echo 'checking successor of node ('.$node.') ... '.PHP_EOL;
        //pemeriksaan suksessor
        echo '<pre>' . print_r($this,true);
        echo 'searching opened : ' . array_search($node,$this->opened) .PHP_EOL;
        echo 'searching closed : ' . array_search($node,$this->closed) .PHP_EOL;
        if(array_search($node,$this->opened) !== false){
            //suksessor di temukan di opened list
            //meaning sudah pernah dibuka, tapi tidak dipilih sebagai best nodes
            //recalculate f

            $old = $this->gCostNodes[$node];
            echo 'old (opened)= ' . print_r($old,true).PHP_EOL;
        }elseif(array_search($node,$this->closed) !== false){
            //suksesor ditemukan di closed list
            //meaning sudah pernah di jelajahi
            //recalculate g
            $old = $this->getTotalG($node);
            echo 'old (closed)= ' . print_r($old, true).PHP_EOL;

        }else{
            //suksessor tidak ditemukan di closed maupun di opened
            //add to the open node
            $this->openNode($node);
        }
    }

    public function getFValue($node){
        if($node !== $this->start) {
            $h = \App\Models\heuristic::find($node)->pluck('hCost');
            $f = $this->gCostNodes[$node] + $h;

            return $f;
        }
    }

    public function getNodeName(){
        $this->result = '';
        foreach($this->closed as $key){
            $kota = \App\Models\kota::find($key);
            $this->result = $this->result . $kota->namaKota . ' - ';
        }
        return $this->result;
    }
}