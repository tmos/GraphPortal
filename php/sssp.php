<?php
$recu='{"size":6,"nodes":[{"id":1},{"id":2},{"id":3},{"id":4},{"id":5},{"id":6}],"edges":[{"nodes":[0,1],"weight":1},{"nodes":[0,2],"weight":2},{"nodes":[1,2],"weight":1},{"nodes":[1,3],"weight":3},{"nodes":[1,4],"weight":2},{"nodes":[2,3],"weight":1},{"nodes":[2,4],"weight":2},{"nodes":[3,4],"weight":4},{"nodes":[4,5],"weight":3}]}';
//or $recu=$_POST["graph"];
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

//echo '<pre>'.json_encode($graphe, JSON_PRETTY_PRINT).'</pre>';
//echo '<pre>'.json_encode($d, JSON_PRETTY_PRINT).'</pre>';

echo json_encode($d);
