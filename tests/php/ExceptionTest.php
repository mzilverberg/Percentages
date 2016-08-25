<?php
// Require class
require_once("../dist/php/Percentages.class.php");

// Automated tests
class ExceptionTest extends PHPUnit_Framework_TestCase {

  // Test if class throws an exception if non-numeric array values are found
  public function testException() {
    try {
      $array = array("ABC");
      $percentages = new Percentages($array);
    } catch (RuntimeException $expected) {
      return;
    }
    $this->fail("An expected exception has not been raised.");
  }

}
?>
