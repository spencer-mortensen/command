<?php

namespace SpencerMortensen\Command\WordWrapper;

require __DIR__ . '/autoload.php';

$maximumWidth = 14;

$input = <<<'EOS'
Roses are red
	Violets are blue

Sugar is sweet
    And so are you.	
EOS;

$wrapper = new WordWrapper($maximumWidth);
$output = $wrapper->wrap($input);

echo $output, "\n";
