<?php

$received = $_POST['graph'];
$graph=array();
$graph=json_decode($received, true);

function adjacentEdges($edges, $node) {
    $res = array();
    for($i = 0; $i < count($edges); $i++) {
        $currentEdge = $edges[$i];
        if ($currentEdge ['from'] == $node || $currentEdge ['to'] == $node) {
            $res[] = $currentEdge ;
        }
    }
    return $res;
}
function isIn($seeked, $edgeList) {
    $res = false;
    foreach ($edgeList as $currentEdge) {
        if ($currentEdge['from'] == $seeked['from'] && $currentEdge['to'] == $seeked['to'] ) {
            $res = true;
            break;
        }
    }
    return $res;
}
$allEdges = $graph['edges'];
$allNodes = $graph['nodes'];

$spanningNodes[] = $allNodes[0]['id'];
$spanningEdges = array();


$i = 0;
while (count($spanningNodes) < count($allNodes) || $i == 500) {
    $min = array(
        'weight' => 11
    );
    // Pour tous les noeuds dans le spaningTree
    foreach ($spanningNodes as $node) {
        // Pour toutes les arrêtes adjacentes à ces noeuds
        foreach (adjacentEdges($allEdges, $node) as $currentEdge) {
            // Si l'arête courante n'est pas déjà enregistrée
            if (!isIn($currentEdge, $spanningEdges)) {
                // On récupère l'arrête de poids minimal
                if ($currentEdge['weight'] < $min['weight']) {
                    // Si le nouveau noeud n'est pas dans spanningNodes
                    if (!in_array($currentEdge['to'], $spanningNodes)) {
                        $min = $currentEdge;
                    }
                }
            }
        }
    }
    $spanningEdges[] = $min;
    $spanningNodes[] = $min['to'];
    $i++;
}
$graph['edges'] = $spanningEdges;
echo json_encode($graph);