<?php

require_once("./markov.php");

// Default options
$filename = "./wdmbtl_text.txt";
$order = 4;
$rand_min = 100;
$rand_max = 300;

// Get options from query string
if (array_key_exists("order", $_GET)) {
	$order = (int) $_GET["order"];
}
if (array_key_exists("min", $_GET)) {
	$rand_min = (int) $_GET["min"];
}
if (array_key_exists("max", $_GET)) {
	$rand_max = (int) $_GET["max"];
}

// Use markov chain to generate random text
$text = file_get_contents($filename);
$length = rand($rand_min, $rand_max);
$markov_table = generate_markov_table($text, $order);
$markov = generate_markov_text($length, $markov_table, $order);

// Format returned text to suck less
$words = explode(" ", $markov);
array_shift($words);
$words[0] = ucfirst($words[0]);
$new_markov = implode(" ", $words);

// Return the review
echo $new_markov;

?>