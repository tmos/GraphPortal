<?php
$recu = '{"nodes":[{"id":1},{"id":2},{"id":3},{"id":4}],"edges":[{"value":2,"from":3,"to":1,"id":"f6ae9bf5-4523-71f2-3501-2bc748174fed"},{"value":4,"from":4,"to":2,"id":"39ab9f77-1eff-3771-c115-c446af32297b"},{"value":1,"from":1,"to":2,"id":"a50d84ff-cfa-1403-6edc-d009f85d5f31"},{"value":2,"from":3,"to":2,"id":"91625e4c-74a7-e3b3-e901-a3123dd642d1"},{"value":9,"from":3,"to":4,"id":"ecd1fa2f-9b58-14a4-e135-4873d15f4c0"},{"value":2,"from":4,"to":1,"id":"c41a607a-65f-d15d-65b6-b1cd9011be38"}],"size":"4"}';

$graphe = array();
$graphe = json_decode($recu, true);


// DEBUT TEST


/*   IL FAUT CONVERTIR LE GRAPHE RECU EN MATRICE D ADJACENCE   */
$G = array(
    0 => array(0, 3, 4, 7),
    1 => array(3, 0, 4, 0),
    2 => array(4, 4, 0, 2),
    3 => array(7, 0, 2, 0),
);

echo '</br>$G :</br>';
for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 4; $j++) {
        echo $G[$i][$j] . ', &nbsp';
    }
    echo '</br>';
}


$nb_noeud = $graphe['size'];
$test[$nb_noeud] = array();

$aretes = $graphe['edges'];

$i = 0;
foreach ($aretes as $arete) {
    echo '</br>Weight arete n°' . $i . ' : ';
    echo $arete['value'];
    if ($arete['value']) {
    }
    $i++;
}


echo '</br>$test :</br>';
for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 4; $j++) {
        echo $test[$i][$j];
    }
    echo '</br>';
}

// FIN TEST


/* KRUSKAL FONCTIONNEL SE SERVANT D UNE MATRICE D ADJACENCE */
function Kruskal(&$G)
{
    $len = count($G);

    // 1. Make T the empty tree (we'll modify the array G to keep only MST
    $T = array();

    // 2. Make a single node trees (sets) out of each vertex
    $S = array();
    foreach (array_keys($G) as $k) {
        $S[$k] = array($k);
    }

    // 3. Sort the edges
    $weights = array();
    for ($i = 0; $i < $len; $i++) {
        for ($j = 0; $j < $i; $j++) {
            if (!$G[$i][$j]) continue;

            $weights[$i . ' ' . $j] = $G[$i][$j];
        }
    }
    asort($weights);

    foreach ($weights as $k => $w) {
        list($i, $j) = explode(' ', $k);

        $iSet = find_set($S, $i);
        $jSet = find_set($S, $j);
        if ($iSet != $jSet) {
            $T[] = "Edge: ($i, $j)";
            union_sets($S, $iSet, $jSet);
        }
    }

    return $T;
}

function find_set(&$set, $index)
{
    foreach ($set as $k => $v) {
        if (in_array($index, $v)) {
            return $k;
        }
    }

    return false;
}

function union_sets(&$set, $i, $j)
{
    $a = $set[$i];
    $b = $set[$j];
    unset($set[$i], $set[$j]);
    $set[] = array_merge($a, $b);
}

$mst = Kruskal($G);

//Edge: (8, 7)
//Edge: (6, 2)
//Edge: (7, 5)
//Edge: (1, 0)
//Edge: (5, 2)
//Edge: (3, 2)
//Edge: (2, 1)
//Edge: (4, 3)
echo '</br>Résultat :</br>';
foreach ($mst as $v) {
    echo $v . PHP_EOL . '</br>';
}

?>
