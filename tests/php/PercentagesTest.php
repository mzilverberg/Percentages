<?php
// phpcs:ignoreFile
// Require class file.
require_once '../source/php/class-percentages.php';
use MZ\Percentages as Percentages;

// Automated tests.
class PercentagesTest extends PHPUnit_Framework_TestCase {

	/**
	 * Test if class returns all percentages in its most basic implementation.
	 */
	public function testInitBasic() {
		$int         = array( 0, 1 );
		$percentages = new Percentages( $int );
		$percentages = $percentages->get();
		// Expect the function to return 3 arrays and the sum of rounded and rectified percentages.
		$this->assertArrayHasKey( 'absolute', $percentages );
		$this->assertArrayHasKey( 'rounded', $percentages );
		$this->assertArrayHasKey( 'corrected', $percentages );
		$this->assertArrayHasKey( 'rounded_sum', $percentages );
		$this->assertArrayHasKey( 'corrected_sum', $percentages );
		// Expect 2 items per array.
		$this->assertCount( count( $int ), $percentages['absolute'] );
	}

	/**
	 * Test if class returns absolute percentages correctly.
	 */
	public function testInitAbsolute() {
		$int         = array( 1, 2, 3, 4, 5 );
		$percentages = new Percentages( $int );
		$absolute    = $percentages->get_absolute();
		// Expect the first value to be ~6.67%.
		$this->assertEquals( number_format( 6.67, 2 ), number_format( $absolute[0], 2 ) );
	}

	/**
	 * Test if class returns rounded percentages correctly.
	 */
	public function testInitRounded() {
		$int         = array( 1, 2, 3, 4, 5 );
		$percentages = new Percentages( $int );
		$rounded     = $percentages->get_rounded();
		// Expect the first value to be 6% and the third value to be 20%.
		$this->assertEquals( 6, $rounded[0] );
		$this->assertEquals( 20, $rounded[2] );
		// Expect 100% will not be reached.
		$this->assertLessThan( 100, $percentages->get_rounded_sum() );
	}

	/**
	 * Test if class returns rectified percentages correctly.
	 */
	public function testInitCorrected() {
		$int         = array( 1, 2, 3, 4, 5 );
		$percentages = new Percentages( $int );
		$corrected   = $percentages->get_corrected();
		// Expect the fourth value to be rounded up.
		$expected = floor( ( $int[3] / array_sum( $int ) * 100 ) ) + 1;
		$this->assertEquals( $expected, $corrected[3] );
		// Expect a total of 100%.
		$this->assertEquals( 100, $percentages->get_corrected_sum() );
	}

	/**
	 * Test if class correctly rectifies 49.5% and 50.5%.
	 */
	public function testRoundingHalves() {
		$int         = array( 495, 505 );
		$percentages = new Percentages( $int );
		$corrected   = $percentages->get_corrected();
		// Expect the first value to be 49% and the second to be 51%.
		$this->assertEquals( 49, $corrected[0] );
		$this->assertEquals( 51, $corrected[1] );
	}

	/**
	 * Doublecheck if class correctly rectifies 49.5% and 50.5% (by reversing the array).
	 */
	public function testRoundingHalvesReversed() {
		$int         = array( 505, 495 );
		$percentages = new Percentages( $int );
		$corrected   = $percentages->get_corrected();
		// Expect the first value to be 51% and the second to be 49%.
		$this->assertEquals( 51, $corrected[0] );
		$this->assertEquals( 49, $corrected[1] );
	}

}
