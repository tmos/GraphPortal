<?php

$arr = array(
	'size' => 4,
	'nodes' => array(
		array(
			'id' => 1,
		),
		array(
			'id' => 2,
		),
		array(
			'id' => 3,
		),
		array(
			'id' => 4,
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