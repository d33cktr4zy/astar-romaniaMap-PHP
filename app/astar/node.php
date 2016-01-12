<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/8/2016
 * Time: 09:23 AM
 */

namespace app\astar;

use App\Models\kota;
use App\Models\real;
use Exception;

class node
{
    /**
     * @var integer     The ID of the object that represent the ID of kota
     */
    public $id;

    /**
     *
     * @var kota        Representation of kota Model
     */
    public $model;

    /**
     * @var integer     The ID of the parent node to be easily recalled
     */
    public $parentID;

    /**
     * @var array       Array of all the nodes that are connected to this node
     *
     * structure        id => $gCostToChild
     */
    public $children;

    /**
     * @var integer     the gCost of this node to its parent
     */
    public $gCostToParent;

    /**
     * @var integer     the total GCost of parent node
     */
    public $gCostOfParent;

    /**
     * @var integer     The sum of gCostOfParent + gCostToParent
     */
    public $gTotal;

    /**
     * @var integer     The heuristic value of the current node
     */
    public $hValue;

    /**
     * @var integer     The sum of gTotal + hValue
     */
    public $fValue;

    /**
     * @var string      the variable name of the instance
     */
    public $name;

    public $parent;


    /**
     * node constructor.
     * This Object should minimally have the id to represent its existance
     * The parent ID is optional as the start node and the final node does not have a parent
     *
     * When a node object is instantiated, it should also retrieve its kota Model
     * then it will also retrieve its children
     * when the parent is set, it will also calculate its current fValue
     * ------------------------------------------------------------------------
     * @param $id
     * @param $name
     * @param node $prent
     * @internal param node $parent
     * @internal param $parentID
     */
    public function __construct($id, $name, node $prent = null){
        $this->id = $id;
        $this->parent = $prent;
        $this->name = $name;


        $this->createModel($id);


        $this->hValue = $this->getHeuristic();
        if(null !== $this->parent){
            $this->parentID = $prent->id;

            $this->gCostOfParent = $this->getGCostOfParent();

            $this->gCostToParent = $this->getGCostToParent();

            $this->gTotal = $this->calculateTotalGCost();

            $this->fValue = $this->calculateFValue();

        }
        $this->children = $this->lookAround();
    }

    public function createModel($id){
        try {
            $this->model = kota::find($id);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function lookAround(){
        if(null !== $this->model->dariKota->first()) {
            foreach ($this->model->dariKota as $key => $data) {
                if($data->idKotaAsal != $this->parentID) {
                    $children[$data->idKotaAsal] = $data->gCost;
                }
            }
        }

        if(null !== $this->model->keKota->first()){
            foreach($this->model->keKota as $key => $data){
                if($data->idKotaTujuan != $this->parentID) {
                    $children[$data->idKotaTujuan] = $data->gCost;
                }
            }
        }

        if(isset($children)) {
            return $children;
        }
    }

    public function getGCostOfParent(){
        if(null !== $this->parent){
            //
            if(isset($this->parent)) {
                $vals = $this->parent->gTotal;
            }else{
                $vals = 0;
            }
        }else{
            $vals = 0;
        }

        return $vals;
    }

    public function getGCostToParent(){
        $gCost = real::where(function($q){
            $q->where('idKotaAsal', $this->parentID)
                ->where('idKotaTujuan', $this->id)
                ->orWhere('idKotaAsal', $this->id)
                ->where('idKotaTujuan', $this->parentID);
        })->pluck('gCost');

        return $gCost;
    }

    public function calculateTotalGCost(){
        $totalG = $this->gCostOfParent + $this->gCostToParent;

        return $totalG;

    }

    public function getHeuristic(){
        $hval = $this->model->hCost->hCost;

        return $hval;
    }

    public function calculateFValue(){
        $fValue = $this->gTotal + $this->hValue;

        return $fValue;
    }




}