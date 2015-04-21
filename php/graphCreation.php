<?php
if (isset($_POST['numberOfNodes'])) {
  $maxN = $_POST['numberOfNodes'];
} else {
  $maxN = 6;
}

$maxE = ($maxN*($maxN-1))/2;
$minE = $maxN - 1;
$nodes = array();

for($i = 1; $i <= $maxN; $i++) {
  $nodes[] = array('id' => $i);
}

// generate random edges
$e = [];
for($n = 1; $n <= $maxE || count($e) < $minE; $n++) {
  $e[] = [rand(1, $maxN), rand(1, $maxN)];

  // remove duplicates and self-loops
  $dup = [];
  foreach($e as $i => $v) {
    if ($v[0] == $v[1]) {
      unset($e[$i]);
      $n--;
    }
    $d = $v[0].':'.$v[1];

    if (isset($dup[$d])) {
      unset($e[$i]);
      $n--;
    } else {
      $dup[$d] = true;
    }

    foreach($e as $a => $j) {
      if ($j[0] == $v[1] && $j[1] == $v[0]) {
        unset($e[$a]);
      }
    }
  }
}

$edges = array();

foreach($e as $edge) {
  list($from, $to) = $edge;
  $tempEdge = array();
  $tempEdge['nodes'] = array($from, $to);
  $tempEdge['weight'] = rand(1,10);
  $edges[] = $tempEdge;
}


$arr = array(
  'size' => $maxN,
  'nodes' => $nodes,
  'edges' => $edges
);

//echo '<pre>'.json_encode($arr, JSON_PRETTY_PRINT).'</pre>';
echo json_encode($arr);

?>
