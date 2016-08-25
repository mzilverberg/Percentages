<?php
// Require class
require_once("../dist/php/Percentages.class.php");

// Automated tests
class PercentagesTest extends PHPUnit_Framework_TestCase {

  // Test if class returns all percentages in its most basic implementation
  public function testInitBasic() {
    // New instance
    $int = array(0, 1);
    $percentages = new Percentages($int);
    $percentages = $percentages->get();
    // Expect 3 arrays to be returned
    $this->assertArrayHasKey("abs", $percentages);
    $this->assertArrayHasKey("rounded", $percentages);
    $this->assertArrayHasKey("corrected", $percentages);
    // Expect 2 items per array
    $this->assertCount(count($int), $percentages["abs"]);
  }

  // Test if class returns absolute percentages correctly
  public function testInitAbsolute() {
    // New instance
    $int = array(1, 2, 3, 4, 5);
    $percentages = new Percentages($int);
    $percentages = $percentages->get("abs");
    // Expect the first value to be ~6.67%
    $this->assertEquals(number_format(6.67, 2), number_format($percentages[0], 2));
  }

  // Test if class returns rounded percentages correctly
  public function testInitRounded() {
    // New instance
    $int = array(1, 2, 3, 4, 5);
    $percentages = new Percentages($int);
    $percentages = $percentages->get("rounded");
    // Expect the third value to be 20%
    $this->assertEquals(6, $percentages[0]);
    $this->assertEquals(20, $percentages[2]);
    // Expect 100% will not be reached
    $this->assertLessThan(100, array_sum($percentages));
  }

  // Test if class returns corrected percentages correctly
  public function testInitCorrected() {
    // New instance
    $int = array(1, 2, 3, 4, 5);
    $percentages = new Percentages($int);
    $percentages = $percentages->get("corrected");
    // Expect the fourth value to be rounded up
    $expected = floor(($int[3] / array_sum($int) * 100)) + 1;
    $this->assertEquals($expected, $percentages[3]);
    // Expect a total of 100%
    $this->assertEquals(100, array_sum($percentages));
  }

  // Test if class correctly calculates 49.5% and 50.5%
  public function testRoundingHalves() {
    // New instance
    $int = array(495, 505);
    $percentages = new Percentages($int);
    $percentages = $percentages->get("corrected");
    // Expect the first value to be 49% and the second to be 51%
    $this->assertEquals(49, $percentages[0]);
    $this->assertEquals(51, $percentages[1]);
  }

  // Test if class correctly calculates 49.5% and 50.5%
  public function testRoundingHalvesReversed() {
    // New instance
    $int = array(505, 495);
    $percentages = new Percentages($int);
    $percentages = $percentages->get("corrected");
    // Expect the first value to be 51% and the second to be 49%
    $this->assertEquals(51, $percentages[0]);
    $this->assertEquals(49, $percentages[1]);
  }

}
?>
