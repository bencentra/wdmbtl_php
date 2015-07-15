<?php

function megabytes($mb) {
	return $mb * 1000000;
}

$filename = "./wdmbtl_text.txt";

// Get latest data from kimono
$request = "https://www.kimonolabs.com/api/8muy71q2?apikey=0skdw5OnhItylr0NF735zSFoWJ12F9is";
$response = file_get_contents($request);
$results = json_decode($response, TRUE);
$reviews = $results["results"]["collection1"];

// Append review bodies together
$corpus = "";
foreach($reviews as $review) {
	$text = $review["review"]["text"];
	$body = explode("\n", $text)[5];
	$corpus .= $body . " ";
}

// Write new reviews to file
file_put_contents($filename, $corpus, FILE_APPEND);

// Shrink reviews file if it's getting too big
if (filesize($filename) > megabytes(0.5)) {
	$old_content = file_get_contents($filename, false, null, megabytes(0.25));
	file_put_contents($filename, $old_content);
}

?>