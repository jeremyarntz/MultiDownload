<?php
define("MEBIBYTE", 1048576);

if(isset($argv[1])) {
	$url = $argv[1];
} else {
	echo "A variable containing the URL to retrieve data from is required\n";
	die();
}

$outputFile = 'download.txt';
if(isset($argv[2])) {
	$outputFile = $argv[2];
}

$chunks = 4;
$chunkSize = MEBIBYTE;
$start = 0;
$incriment = $chunkSize - 1;
$data = '';

echo "Retrieving Data From: $url\n";

for ($currentChunk = 1; $currentChunk <= $chunks; $currentChunk++) {
	$end = $start + $incriment;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RANGE, $start.'-'.$end);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$data .= $result;
	curl_close($ch);

	$start = $end+1;
}

echo "Writing Data to: $outputFile\n";
file_put_contents ($outputFile, $data );
echo "Finished.\n";
