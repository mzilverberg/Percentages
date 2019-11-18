<?php
// phpcs:ignoreFile
require '../source/php/class-percentages.php';
use MZ\Percentages as Percentages;

// Define options for the poll we'll use in the example.
$options = array(
	array(
		'name'  => 'React',
		'votes' => 21,
	),
	array(
		'name'  => 'Vue',
		'votes' => 13,
	),
	array(
		'name'  => 'Svelte',
		'votes' => 0,
	),
	array(
		'name'  => 'jQuery',
		'votes' => 4,
	),
	array(
		'name'  => 'Vanilla JS',
		'votes' => 1,
	),
);

// Store percentages and totals.
$votes         = array_map(
	function( $item ) {
		return $item['votes'];
	},
	$options
);
$instance      = new Percentages( $votes );
$percentages   = $instance->get();
$absolute      = $percentages['absolute'];
$rounded       = $percentages['rounded'];
$corrected     = $percentages['corrected'];
$rounded_sum   = $percentages['rounded_sum'];
$corrected_sum = $percentages['corrected_sum'];

// Encode options in JSON so we can use it in JavaScript as well.
$json_options = json_encode( $options );

?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Percentages: a JavaScript function and PHP class for calculating percentages</title>
	<!-- CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1>Percentages</h1>
				<div class="row">
					<div class="col-md-6">
						<p>This example uses both the PHP and JavaScript classes. Initially, the poll's options and votes are determined server-side. All percentages are calculated server-side, too, and displayed in the table below. Additionally, the input data is passed as JSON to JavaScript. From the moment you cast a vote, all data will be handled by the JavaScript class.</p>
						<p>For the sake of the demo, the amount of votes is shown and voting will not be disabled after you cast a vote.</p>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div id="example">
							<table class="table">
								<thead>
									<tr>
										<th colspan="3">Framework</th>
										<th colspan="3">Percentage (%)</th>
									</tr>
									<tr>
										<th>Name</th>
										<th colspan="2">Votes</th>
										<th>Absolute</th>
										<th>Rounded</th>
										<th>Corrected</th>
									</tr>
								</thead>
								<?php
								/**
								 * We pass the `$json_options` variable in a data-attribute to the table body, so we can use the server-side example data as a starting point in JavaScript.
								 */
								?>
								<tbody data-options='<?php echo $json_options; ?>'>
									<?php foreach ( $options as $index => $option ) { ?>
										<tr class="visible">
											<td><?php echo $option['name']; ?></td>
											<td><?php echo $option['votes']; ?></td>
											<td><button class="btn btn-primary" v-on:click.once="switchToJS(<?php echo $index; ?>)">Vote!</button></td>
											<td><?php echo $absolute[ $index ]; ?>%</td>
											<td><?php echo $rounded[ $index ]; ?>%</td>
											<td><?php echo $corrected[ $index ]; ?>%</td>
										</tr>
									<?php } ?>
									<?php
									/**
									 * Both the server-side and client-side rows are rendered.
									 * We distinguish them by the CSS classes `visible` (server-side) and `hidden` (client-side). The same goes for cells in the table footer.
									 * When switching from server to client-side handling, we remove the server-side rows and cells and show client-side rows and cells.
									 */
									?>
									<template v-for="(option, index) in options">
										<tr class="hidden">
											<td>{{ option.name }}</td>
											<td>{{ option.votes }}</td>
											<td><button class="btn btn-primary" v-on:click="vote(option)">Vote!</button></td>
											<td>{{ percentages.absolute[index] }}%</td>
											<td>{{ percentages.rounded[index] }}%</td>
											<td>{{ percentages.corrected[index] }}%</td>
										</tr>
									</template>

								</tbody>
								<tfoot>
									<tr>
										<th scope="row" colspan="4">Total percentage (%)</th>
										<th scope="column">
											<span class="visible"><?php echo $rounded_sum; ?>%</span>
											<span class="hidden">{{ percentages.roundedSum }}%</span>
										</th>
										<th scope="column">
											<span class="visible"><?php echo $corrected_sum; ?>%</span>
											<span class="hidden">{{ percentages.correctedSum }}%</span>
										</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<script type="text/javascript" src="dist/example.js"></script>

</body>
</html>
