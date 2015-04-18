<?php 

$arr = array(
	'nodes' => array(
		array(
			'links' => array(1,2),
		),
		array(
			'links' => array(3,2),
		),
		array(
			'links' => array(4,3,1),
		),
		array(
			'links' => array(4),
		)

	),
	'edges' => array(
		array(
			'nodes' => array(1,3),
			'weight' => 1
		),
		array(
			'nodes' => array(1,2),
			'weight' => 2
		),
		array(
			'nodes' => array(2,3),
			'weight' => 7
		),
		array(
			'nodes' => array(4,3),
			'weight' => 3
		),
	)
);

/*
 * Human readable debug
 * echo '<pre>'.json_encode($arr, JSON_PRETTY_PRINT).'</pre>';
 *
 */

echo json_encode($arr);