<?php
$recu=$_POST["graph"];
//$recu = '{"nodes":[{"id":1},{"id":2},{"id":3},{"id":4}],"edges":[{"value":2,"from":3,"to":1,"id":"f6ae9bf5-4523-71f2-3501-2bc748174fed"},{"value":4,"from":4,"to":2,"id":"39ab9f77-1eff-3771-c115-c446af32297b"},{"value":1,"from":1,"to":2,"id":"a50d84ff-cfa-1403-6edc-d009f85d5f31"},{"value":2,"from":3,"to":2,"id":"91625e4c-74a7-e3b3-e901-a3123dd642d1"},{"value":9,"from":3,"to":4,"id":"ecd1fa2f-9b58-14a4-e135-4873d15f4c0"},{"value":2,"from":4,"to":1,"id":"c41a607a-65f-d15d-65b6-b1cd9011be38"}],"size":"4"}';
$graphe=array();
$graphe=json_decode($recu, true);

$nb_noeud=$graphe["size"];

$d[$nb_noeud]=array();//variable pour definir le sssp

/*test
$dist=array('0','1','2','3','4','5');
$dist[0]=array('0','0','0','0','0','0');
$dist[1]=array('0','0','0','0','0','0');
$dist[2]=array('0','0','0','0','0','0');
$dist[3]=array('0','0','0','0','0','0');
$dist[4]=array('0','0','0','0','0','0');
$dist[5]=array('0','0','0','0','0','0');
//variable contenant les distances entre chaque point lorqu'il y a une arete, 0 si il n'y en a pas
*/

$dist=array();
for ($i=0;$i<$nb_noeud;$i++){
        array_push($dist, $i);
        $dist[$i]=array();
        for($j=0;$j<$nb_noeud;$j++){
                array_push($dist[$i],0);
        }
}



for ($i = 0; $i < $nb_noeud; ++$i){
        for ($j = 1; $j <= $nb_noeud; ++$j){
                $dist[$i][$j]=0;
        }
}

foreach($graphe["edges"] as $arete){
        $dist[$arete["nodes"][0]][$arete["nodes"][1]]=$arete["weight"];
        $dist[$arete["nodes"][1]][$arete["nodes"][0]]=$arete["weight"];
}


$mini;//variable qui memorise le chemin le plus court
$visited[$nb_noeud]=array();//variable qui memorise les noeuds deja visites

for ($i = 0; $i < $nb_noeud; ++$i) {
        $d[$i] = INF;
        $visited[$i] = 0;//aucun noeud n'a encore été visité
}
$d[0] = 0;//le chemin du premier point au premier point = 0

for ($k = 0; $k < $nb_noeud; ++$k) {
        $mini = -1;
        for ($i = 0; $i < $nb_noeud; ++$i){
                if (!$visited[$i] && (($mini == -1) || ($d[$i] < $d[$mini]))){
                        $mini = $i;
                }
        }
        $visited[$mini] = 1;

        for ($i = 0; $i < $nb_noeud; ++$i){
                if ($dist[$mini][$i]){
                        if ($d[$mini] + $dist[$mini][$i] < $d[$i]){
                                $d[$i]= $d[$mini] + $dist[$mini][$i];
                        }
                }
        }
}
//echo $_POST["graph"];
echo json_encode($d);