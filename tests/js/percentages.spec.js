describe("Initiation", function() {

  // Globals
  var int,
  percentages;

  // Helpers
  beforeEach(function() {
    int = [1, 2, 3, 4, 5];
    percentages = new Percentages(int);
  });

  Array.prototype.sum = function() {
    return this.reduce(function(a, b) {
      return a + b;
    });
  };

  // Test if function returns all percentages in its most basic implementation
  it("Test most basic implementation", function() {
    // Expect an object with 3 arrays to be returned
    expect(percentages.abs).toBeDefined();
    expect(percentages.rounded).toBeDefined();
    expect(percentages.corrected).toBeDefined();
    // Expect 2 items per arrays
    expect(percentages.abs.length).toEqual(int.length);
  });

  // Test if class returns absolute percentages correctly
  it("Test absolute percentages", function() {
    // Get absolute percentages
    percentages = percentages.abs;
    // Expect the first value to be ~6.67%
    expect(percentages[0].toFixed(2)).toEqual(6.67.toFixed(2));
  });

  // Test if class returns rounded percentages correctly
  it("Test rounded percentages", function() {
    // Get absolute percentages
    percentages = percentages.rounded;
    // Expect the first value to be ~6.67%
    expect(percentages[0]).toEqual(6);
    expect(percentages[2]).toEqual(20);
    // Expect 100% will not be reached
    expect(percentages.sum()).toBeLessThan(100);
  });

  // Test if class returns corrected percentages correctly
  it("Test corrected percentages", function() {
    // Get corrected percentages
    percentages = percentages.corrected;
    // Expect the fourth value to be rounded up
    var expected = Math.floor((int[3] / int.sum() * 100)) + 1;
    expect(percentages[3]).toEqual(expected);
    // Expect a total of 100%
    expect(percentages.sum()).toEqual(100);
  });

  // Test if class correctly calculates 49.5% and 50.5%
  it("Test rounding halves", function() {
    // Override values
    int = [495, 505];
    percentages = new Percentages(int).corrected;
    // Expect the first value to be 49% and the second to be 51%
    expect(percentages[0]).toEqual(49);
    expect(percentages[1]).toEqual(51);
  });

  // Test if class correctly calculates 49.5% and 50.5%, but then reversed
  it("Test rounding halves reversed", function() {
    // Override values
    int = [505, 495];
    percentages = new Percentages(int).corrected;
    // Expect the first value to be 51% and the second to be 49%
    expect(percentages[0]).toEqual(51);
    expect(percentages[1]).toEqual(49);
  });

});
