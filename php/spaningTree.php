<?php

$recu = '{
    "size": 5,
    "nodes": [
        {
            "id": 1
        },
        {
            "id": 2
        },
        {
            "id": 3
        },
        {
            "id": 4
        },
        {
            "id": 5
        }
    ],
    "edges": [
        {
            "from": 1,
            "to": 3,
            "weight": 10
        },
        {
            "from": 2,
            "to": 3,
            "weight": 5
        },
        {
            "from": 1,
            "to": 4,
            "weight": 3
        },
        {
            "from": 1,
            "to": 2,
            "weight": 2
        },
        {
            "from": 1,
            "to": 5,
            "weight": 7
        },
        {
            "from": 3,
            "to": 5,
            "weight": 2
        },
        {
            "from": 4,
            "to": 5,
            "weight": 8
        }
    ]
}';

$graph=array();
$graph=json_decode($recu, true);


$edges = $graph['edges'];
$nodes = $graph['nodes'];

// Depart au sommet 1
$startNode = $nodes[0];
echo "Start node:   ".$startNode['id']."<br>";

$listCurrentEdges = array();
$currentEdge = array();
$currentNode = array();
$currentNode[] = $nodes[0];
$spanningEdges = array();
$min = array(
    'weight' => 11
);




//echo '<pre>'.json_encode($queue, JSON_PRETTY_PRINT).'</pre>';


