<?php
// phpcs:ignoreFile
require '../../source/php/class-percentages.php';
use MZ\Percentages as Percentages;

// We need an array of votes to be passed.
if ( ! isset( $_GET['votes'] ) ) {
	die( 'No votes were passed as an argument' );
}

// Return percentage values based on options (passed as `[1,2,3]` for example).
$votes       = json_decode( $_GET['votes'], true );
$instance    = new Percentages( $votes );
$percentages = $instance->get();

// Return JSON-formatted output.
// We need to map the values since some JavaScript keys differ from their PHP equivalents.
header( 'Content-type: application/json' );
echo json_encode(
	array(
		'absolute'     => $percentages['absolute'],
		'rounded'      => $percentages['rounded'],
		'corrected'    => $percentages['corrected'],
		'roundedSum'   => $percentages['rounded_sum'],
		'correctedSum' => $percentages['corrected_sum'],
	)
);
