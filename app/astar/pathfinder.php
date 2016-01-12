<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 1/8/2016
 * Time: 09:32 AM
 */

namespace app\astar;

include 'ddd.php';

class pathFinder
{
    /**
     * @var node
     */
    public $startNode;
    /**
     * @var node
     */
    public $finalNode;

    /**
     * @var array
     */
    public $openQueue;

    /**
     * @var array
     */
    public $processedNodes;

    public $currentNode;

    /**
     * pathFinder constructor.
     * @param $startNode
     * @param $finalNode
     */
    public function __construct(node $startNode, node $finalNode)
    {
        $this->startNode = $startNode;
        $this->finalNode = $finalNode;
    }

    public function findPath(){

        $startNode = $this->startNode;
        $finalNode = $this->finalNode;

        //inisialisasi
        $this->node{$startNode->id} = $startNode;
        $this->currentNode = $this->node{$startNode->id};
        $this->addToOpenQueue($startNode);

        $itsCounter = 1;
        while($this->currentNode->id != $finalNode->id){
            ddd('starting iteration number '.$itsCounter);
            ddd('----------------------------------',$this->currentNode->id, $finalNode->id,'----------------------------------');
            //sanity check
            if(count($this->openQueue) == 0){
                return false;
            }

            //getting minimal f
            $idNodeWithMinimalFValue = $this->getMinimalFValue();
            if($this->node{$idNodeWithMinimalFValue}->id === $finalNode->id){
                $this->currentNode = $this->node{$idNodeWithMinimalFValue};
                continue;
            }
            ddd('openStack', $this->openQueue);
            $this->moveToProcessedNodes($this->node{$idNodeWithMinimalFValue});
            ddd('ninimal node', $this->node{$idNodeWithMinimalFValue});
            ddd('prcessedNodes', $this->processedNodes);

            //bangkitkan semua suksesor
            //periksa suksesor
            $this->checkChildren($this->node{$idNodeWithMinimalFValue});

            ddd($this);

            $idNodeWithMinimalFValue = $this->getMinimalFValue();
            $this->currentNode = $this->node{$idNodeWithMinimalFValue};

            ddd('ending iteration number '. $itsCounter);
            $itsCounter++;
            if($itsCounter == 5){
//                dd('breaking');
            }
        }

        $path = $this->traceBack();
        ddd('path',$path);
        foreach($path as $key => $id){
            if(!isset($bestPath)){
                $bestPath = $this->node{$id}->model->namaKota;
            }else {
                $bestPath = $bestPath . ' - ' . $this->node{$id}->model->namaKota;
            }
        }

        ddd('Final Destination reached. Dumping Best Path');
        ddd($bestPath);
        return $bestPath;
    }

    public function addToOpenQueue(node $node)
    {
        //sanity check
        if(null !== $this->openQueue) {
            if (array_search($node->id, $this->openQueue)) {
                return 'the node is already in the Open Stack';
            }
        }

        $this->openQueue[] = $node->id;
    }

    /**
     * @param node $node
     * @return string
     */
    public function moveToProcessedNodes(node $node){
        //sanity check
        ddd('node to move', $node , 'open', $this->openQueue);
        if(array_search($node->id,$this->openQueue) === false){
            ddd(array_search($node->id, $this->openQueue));
            ddd('nothing to move. The Node is not in the Open Stack');
            return 'nothing to move. The Node is not in the Open Stack';
        }
        $this->processedNodes[] = $node->id;
        $this->openQueue = array_diff($this->openQueue,[$node->id]);
    }

    /**
     * @return mixed
     */
    public function getMinimalFValue()
    {
        foreach($this->openQueue as $key =>$nodeID){
//            ddd($key, $nodeID);
            ddd($this->openQueue);
            $fValues[$nodeID] = $this->node{$nodeID}->fValue;
        }
        ddd('FFalues : ', $fValues);
        $minF = array_keys($fValues,min($fValues));

        return $minF[0];
    }

    /**
     * @param $id
     * @param node $parent
     * @param null $name
     * @return mixed
     */
    public function makeNode($id,node $parent,$name=null){
        if(null === $name){
            $name = 'node'.$id;
        }
        if(strpos('child', $name) !== false){
            $explosion = explode('-', $name);
            if(!isset($explosion[1])) {
                $this->child{$parent->id} = new node($id, $name, $parent);
                return $this->child{$parent->id};
            }else{
                $this->child{$explosion[1]} = new node($id,$name, $parent);
                return $this->child{$explosion[1]};
            }
        }else{
            $this->node{$id} = new node($id, $name, $parent);
            return $this->node{$id};
        }
    }

    public function checkChildren(node $parens)
    {
        if(null !== $parens->children) {
            foreach ($parens->children as $id => $gCost) {
                $child = $this->makeNode($id, $parens, 'child');
                $intheOpen = $this->inTheOpenQueue($child);
                $beenProcessed = $this->inTheProcessedNodes($child);

                if (!$intheOpen && !$beenProcessed) {
                    //confirm making the child node and add it to open
                    if ($this->makeNode($id, $parens) !== false) {
                        //adding the newly created node to
                        $this->addToOpenQueue($this->node{$id});
                        ddd('new Child should have been born', $this->node{$id});
                    }
                }
//            ddd($child, $intheOpen, $beenProcessed);
            }
        }
    }

    public function inTheOpenQueue(node $child){
        if(null !== $this->openQueue) {
            if ($key = array_search($child->id, $this->openQueue)) {
                //id was found in the openQueue
                ddd('found in OpenQueue... doing things to the node');
                if (!isset($this->node{$child->id})) {
                    ddd("the node" . $child->id . " has never been instantiated");
                    return false;
                }
                //comparing child with node
                if ($this->node{$child->id}->gTotal < $child->gTotal) {
                    $this->node{$child->id}->parent = $child->parent;
                    $this->node{$child->id}->parentID = $child->parentID;
                    $this->node{$child->id}->gCostOfParent = $this->node{$child->id}->getGCostOfParent();
                    $this->node{$child->id}->gCostToParent = $this->node{$child->id}->getGCostToParent();
                    $this->node{$child->id}->gTotal = $this->node{$child->id}->calculateTotalGCost();
                    $this->node{$child->id}->fValue = $this->node{$child->id}->calculateFValue();

                }
//                dd($this->node{$child->id});
                return true;
            }
        }
        return false;
    }

    public function inTheProcessedNodes(node $child){
        if(null !== $this->processedNodes) {
            if ($key = array_search($child->id, $this->processedNodes)) {
                //found a matching id of child in the processedNodes array
                //meaning that the child node is already been processed and
                //has already valid children that is still in the open

                ddd('found child in the processedNode list... doing things to the node');
                ddd($child);

                //sanity check to see that if the node really exist
                if (!isset($this->node{$child->id})) {
                    //never been instantiated
                    ddd('the node' . $child->id . ' has never been instantiated');
                    return false;
                }
//                dd($this->node{$child->id});

                //comparing child
                if ($this->node{$child->id}->gTotal < $child->gTotal) {
                    //the old g is lesser than the child total
                    //then we have to change the parent of the old to the parent of the child
                    //this will affect the g value of old as well as its f value
                    //this also means that any children that it has in the openQueue should be
                    //re-evaluate to reflect the changes of the f value
                    $this->node{$child->id}->parent = $child->parent;
                    $this->node{$child->id}->parentID = $child->parentID;
                    $this->node{$child->id}->gCostOfParent = $this->node{$child->id}->getGCostOfParent();
                    $this->node{$child->id}->gCostToParent = $this->node{$child->id}->getGCostToParent();
                    $this->node{$child->id}->gTotal = $this->node{$child->id}->calculateTotalGCost();
                    $this->node{$child->id}->fValue = $this->node{$child->id}->calculateFValue();

                    //propagate the child
                    foreach ($this->node{$child->id}->children as $childID => $childGCost) {
                        if (array_search($childID, $this->openQueue)) {
                            //child has been found in open
                            if (isset($this->node{$childID})) {
                                $this->propagate($this->node{$childID},$child->parent, $child->parentID);
                            }
                        }
                    }

                }
                return true;
            }
        }
        return false;
    }

    public function propagate(node $node, $parent, $parentID){
        $node->parent = $parent;
        $node->parentID = $parentID;
        $node->gCostOfParent = $node->getGCostOfParent();
        $node->gCostToParent = $node->getGCostToParent();
        $node->gTotal = $node->calculateTotalGCost();
        $node->fValue = $node->calculateFValue();

    }

    public function traceBack()
    {
        $final = $this->finalNode->id;
        ddd($final);
        $start = $this->startNode->id;
        ddd($start);

        $evalNode = $final;
        ddd('eval',$evalNode);
        while($evalNode !== $start){
            $path[] = $evalNode;
            ddd('path',$path);
            $evalNode = $this->node{$evalNode}->parentID;
        }
        $path[] = $start;
        $correctPath = array_reverse($path);
        return $correctPath;
    }


}