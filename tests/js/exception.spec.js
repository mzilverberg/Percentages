describe("Exception", function() {

  // Globals
  var array,
  percentages;

  // Helpers
  beforeEach(function() {
    spyOn(console, "error");
    array = ["ABC"];
    percentages = new Percentages(array);
  });

  // Test if function throws an error if non-numeric array values are found
  it("Test console.error()", function() {
    // Expect an error
    expect(console.error).toHaveBeenCalledWith("Percentages.js Error: Some of the values in the array are not numeric.");
  });

});
