<?php
/**
 * Percentages class. Takes an array of values as the only argument and returns absolute, rounded, and corrected percentages based on the largest remainder method.
 * Additionally, both the sum of the rounded and the corrected percentages are returned.
 *
 * @package    Percentages
 * @author     Maarten Zilverberg <maarten@mzilverberg.nl>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @link       https://github.com/mzilverberg/Percentages
 * @version    2.1.0
 */

namespace MZ;

/**
 * Class that handles percentages through the largest remainder method.
 */
final class Percentages {

	/**
	 * Values passed as argument.
	 *
	 * @var Array
	 */
	private $values;

	/**
	 * Sum of all values passed as argument.
	 *
	 * @var Int
	 */
	private $sum;

	/**
	 * Absolute percentages.
	 *
	 * @var Array
	 */
	private $absolute;

	/**
	 * Rounded percentages.
	 *
	 * @var Array
	 */
	private $rounded;

	/**
	 * Rectified percentages.
	 *
	 * @var Array
	 */
	private $corrected;

	/**
	 * Remainders.
	 *
	 * @var Array
	 */
	private $remainders;

	/**
	 * The sum of rounded percentages.
	 *
	 * @var Int
	 */
	private $rounded_sum;

	/**
	 * The sum of corrected percentages.
	 * This should always be `100`.
	 *
	 * @var Int
	 */
	private $corrected_sum;


	/**
	 * Constructor.
	 *
	 * @param Array $values        Array with values to calculate percentages.
	 */
	public function __construct( $values ) {
		// Store values and initiate instance arrays and integers.
		$this->values        = $values;
		$this->sum           = $this->array_sum( $this->values );
		$this->absolute      = array();
		$this->rounded       = array();
		$this->corrected     = array();
		$this->remainders    = array();
		$this->rounded_sum   = 0;
		$this->corrected_sum = 0;
		// Calculate percentages and rectify them if needed.
		$this->calc();
		$this->rectify();
	}


	/**
	 * Try to calculate the sum of all values in an array.
	 *
	 * @param Array $array        Array containing the values we need to calculate the sum of.
	 * @return Mixed              Sum of array values or RuntimeException.
	 * @throws \RuntimeException  Throw exception if non-numeric arrays are passed to the class' instance.
	 */
	private function array_sum( $array ) {
		try {
			if ( count( $array ) !== array_sum( array_map( 'is_numeric', $array ) ) ) {
				throw new \RuntimeException( '<strong>class-percentages.php Exception:</strong> Some of the values in the array are not numeric.', 1 );
			}
			return array_sum( $array );
		} catch ( \RuntimeException $e ) {
			return $e->getMessage();
		}
	}


	/**
	 * Calculate percentage values.
	 */
	private function calc() {
		$count = count( $this->values );
		for ( $i = 0; $i < $count; $i++ ) {
			// Calculate absolute and rounded percentages. Use the rounded percentages as a starting point for rectified percentage values.
			$absolute  = 0 === $this->sum ? 0 : ( $this->values[ $i ] / $this->sum ) * 100;
			$rounded   = floor( $absolute );
			$remainder = $absolute - $rounded;
			array_push( $this->absolute, $absolute );
			array_push( $this->rounded, $rounded );
			array_push( $this->corrected, $rounded );
			array_push( $this->remainders, $remainder );
		}
		// Calculate the sum of rounded percentages and temporarily use that value for the sum of corrected percentages, as well.
		$this->rounded_sum   = $this->array_sum( $this->rounded );
		$this->corrected_sum = $this->rounded_sum;
	}


	/**
	 * Rectify percentage values if the sum of all rounded percentages does not equal `100`.
	 */
	private function rectify() {
		while ( $this->corrected_sum < 100 ) {
			// Determine the largest remainder and get its array index.
			// If multiple values are found, take the rounded percentage value into account.
			// E.g. rectify percentages of 49,5 and 50,5 to 49 and 51, respectively.
			$largest = max( $this->remainders );
			$indexes = array_keys( $this->remainders, $largest, true );
			$index   = 0;
			if ( count( $indexes ) > 1 ) {
				array_reduce(
					$indexes,
					function( $carry, $item ) use ( &$index ) {
						$index = $this->rounded[ $carry ] > $this->rounded[ $item ] ? $carry : $item;
						return $carry;
					},
					0
				);
			} else {
				$index = $indexes[ $index ];
			}
			$this->corrected[ $index ]++;
			$this->remainders[ $index ] = -1;
			$this->corrected_sum++;
		}
	}


	/**
	 * Return all relevant instance values in an associative array.
	 *
	 * @return Array        Associative array with calculated percentages and sums.
	 */
	public function get() {
		return array(
			'absolute'      => $this->absolute,
			'rounded'       => $this->rounded,
			'corrected'     => $this->corrected,
			'rounded_sum'   => $this->rounded_sum,
			'corrected_sum' => $this->corrected_sum,
		);
	}


	/**
	 * Return absolute percentages.
	 *
	 * @return Array        Absolute percentages based on the instance's values.
	 */
	public function get_absolute() {
		return $this->absolute;
	}


	/**
	 * Return rounded percentages.
	 *
	 * @return Array        Rounded percentages based on the instance's values.
	 */
	public function get_rounded() {
		return $this->rounded;
	}


	/**
	 * Return rectified percentages.
	 *
	 * @return Array        Rectified percentages based on the instance's values.
	 */
	public function get_corrected() {
		return $this->corrected;
	}


	/**
	 * Return sum of rounded percentages.
	 *
	 * @return Int          Sum of all rounded percentages.
	 */
	public function get_rounded_sum() {
		return $this->rounded_sum;
	}


	/**
	 * Return sum of rectified percentages.
	 *
	 * @return Int          Sum of all rectified percentages.
	 */
	public function get_corrected_sum() {
		return $this->corrected_sum;
	}


}
