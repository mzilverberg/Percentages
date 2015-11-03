<?php
/*
Percentages.class.php - v1.1.2
https://github.com/mzilverberg/Percentages
*/
class Percentages {

    // Array sum with error handling
    private function array_sum($array) {
        try {
            // Throw an error if non-numeric array values are found
            if(array_sum(array_map("is_numeric", $array)) !== count($array)) {
                throw new RuntimeException("<strong>Percentages.class.php Exception:</strong> Some of the values in the array are not numeric.", 1);
            }
            // Otherwise, return the sum of all array values
            return array_sum($array);
        } catch(RuntimeException $e) {
            echo $e->getMessage();
        }
    }

    // Calculate percentages
    private function calc_percentages() {
        // Loop through options
        for($i = 0; $i < $this->opt_count; $i++) {
            // Calculate percentages and remainder
            $abs = $this->total === 0 ? 0 : ($this->values[$i] / $this->total) * 100;
            $rounded = floor($abs);
            $remainder = $abs - $rounded;
            // Store percentages and remainders in arrays
            array_push($this->abs, $abs);
            array_push($this->rounded, $rounded);
            array_push($this->corrected, $rounded);
            array_push($this->remainders, $remainder);
        }
        // Fix percentages
        if($this->total !== 0) {
            $this->fix_percentages();
        }
    }

    // Fix rounded percentages if rounded total does not equal 100%
    private function fix_percentages() {
        $rounded_total = $this->array_sum($this->corrected);
        while($rounded_total < 100) {
            // Get highest remainder and its index
            $highest_remainder = max($this->remainders);
            $index = array_search($highest_remainder, $this->remainders);
            // Update rounded percentage
            $this->corrected[$index] = $this->corrected[$index] + 1;
            // Unset current highest remainder
            $this->remainders[$index] = -1;
            // Update total value
            $rounded_total++;
        }
    }

    // Return calculated percentages
    /*
    @param `$variant` (String, optional):     "abs", "rounded" or "corrected"
    */
    public function get($variant = "") {
        // Save variants
        $ret = array(
            "abs"     => $this->abs,
            "rounded" => $this->rounded,
            "corrected"   => $this->corrected
        );
        // If a specific variant is requested, return only that variant
        // Otherwise, return all variants combined
        return $variant !== "" ? $ret[$variant] : $ret;
    }

    // Class constructor
    public function __construct($values) {
        // Store values and amount of options
        $this->values = $values;
        $this->opt_count = count($this->values);
        // Calculate total value count by adding up
        $this->total = $this->array_sum($this->values);
        // Create new arrays for percentages and remainders
        $this->abs = array();
        $this->rounded = array();
        $this->corrected = array();
        $this->remainders = array();
        // Calculate percentages
        $this->calc_percentages();
    }
}
?>
