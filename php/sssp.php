<?php

//$recu = '{"nodes":[{"id":1},{"id":2},{"id":3},{"id":4}],"edges":[{"value":2,"from":3,"to":1,"id":"f6ae9bf5-4523-71f2-3501-2bc748174fed"},{"value":4,"from":4,"to":2,"id":"39ab9f77-1eff-3771-c115-c446af32297b"},{"value":1,"from":1,"to":2,"id":"a50d84ff-cfa-1403-6edc-d009f85d5f31"},{"value":2,"from":3,"to":2,"id":"91625e4c-74a7-e3b3-e901-a3123dd642d1"},{"value":9,"from":3,"to":4,"id":"ecd1fa2f-9b58-14a4-e135-4873d15f4c0"},{"value":2,"from":4,"to":1,"id":"c41a607a-65f-d15d-65b6-b1cd9011be38"}],"size":"4"}';
$recu=$_POST["graph"];

$graphe=array();
$graphe=json_decode($recu, true);
$nb_noeud=$graphe["size"];

$_distArr=array();
for ($i=1;$i<=$nb_noeud;$i++){
        array_push($_distArr, $i);
        $_distArr[$i]=array();
        for($j=1;$j<=$nb_noeud;$j++){
                array_push($_distArr[$i],0);
        }
}
foreach($graphe["edges"] as $arete){
        $_distArr[$arete['from']][$arete['to']]=$arete['value'];
        $_distArr[$arete['to']][$arete['from']]=$arete['value'];
}

for($i=2;$i<=$nb_noeud;$i++){
	//the start and the end
	$a = 1;
	$b = $i;

	//initialize the array for storing
	$S = array();//the nearest path with its parent and weight
	$Q = array();//the left nodes without the nearest path
	foreach(array_keys($_distArr) as $val) $Q[$val] = 99999;
	$Q[$a] = 0;

	//start calculating
	while(!empty($Q)){
	    $min = array_search(min($Q), $Q);//the most min weight
	    if($min == $b) break;
	    foreach($_distArr[$min] as $key=>$val) if(!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
	        $Q[$key] = $Q[$min] + $val;
	        $S[$key] = array($min, $Q[$key]);
	    }
	    unset($Q[$min]);
	}


	$path = array();
	$pos = $b;
	while($pos != $a){
	    $path[] = $pos;
	    $pos = $S[$pos][0];
	}
	$path[] = $a;
	$path = array_reverse($path);

	$tmp = array();
	$tmp['weight'] = $S[$b][1];
	$tmp['from'] = $a;
	$tmp['to'] = $b;

	$d[]=$tmp;
}
echo json_encode($d);
?>
