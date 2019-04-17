<?php

namespace SpencerMortensen\Command;

require __DIR__ . '/autoload.php';

$headers = ['Species', 'Status'];
$rows = [
	['Marmota caligata', 'LC'],
	['Marmota vancouverensis', 'CR']
];

$tableMaker = new TableMaker();
$output = $tableMaker->getText($headers, $rows);

echo $output;
