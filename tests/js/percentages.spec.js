const Percentages = require('../../source/js/Percentages');
describe('Initiation', () => {

  // Globals
  let int;
  let percentages;

  // Helpers
  beforeEach(() => {
    int = [1, 2, 3, 4, 5];
    percentages = new Percentages(int);
  });

  // Test if function returns all percentages in its most basic implementation
  it('Test most basic implementation', () => {
    // Expect an object with the arrays of percentages and 2 sum values to be returned
    expect(percentages.absolute).toBeDefined();
    expect(percentages.rounded).toBeDefined();
    expect(percentages.corrected).toBeDefined();
    expect(percentages.roundedSum).toBeDefined();
    expect(percentages.correctedSum).toBeDefined();
    // Expect 5 items per arrays
    expect(percentages.absolute.length).toEqual(int.length);
  });

  // Test if class returns absolute percentages correctly
  it('Test absolute percentages', () => {
    // Get absolute percentages
    percentages = percentages.absolute;
    // Expect the first value to be ~6.67%
    expect(percentages[0].toFixed(2)).toEqual(6.67.toFixed(2));
  });

  // Test if class returns rounded percentages correctly
  it('Test rounded percentages', () => {
    // Get absolute percentages
    const rounded = percentages.rounded;
    // Expect the first value to be ~6.67%
    expect(rounded[0]).toEqual(6);
    expect(rounded[2]).toEqual(20);
    // Expect 100% will not be reached
    expect(percentages.roundedSum).toBeLessThan(100);
  });

  // Test if class returns corrected percentages correctly
  it('Test corrected percentages', () => {
    // Get corrected percentages
    const corrected = percentages.corrected;
    // Expect the fourth value to be rounded up
    const sum = int.reduce((sum, x) => sum + x);
    const expected = Math.floor((int[3] / sum * 100)) + 1;
    expect(corrected[3]).toEqual(expected);
    // Expect a total of 100%
    expect(percentages.correctedSum).toEqual(100);
  });

  // Test if class correctly calculates 49.5% and 50.5%
  it('Test rounding halves', () => {
    // Override values
    int = [495, 505];
    percentages = new Percentages(int);
    const corrected = percentages.corrected;
    // Expect the first value to be 49% and the second to be 51%
    expect(corrected[0]).toEqual(49);
    expect(corrected[1]).toEqual(51);
  });

  // Test if class correctly calculates 49.5% and 50.5%, but then reversed
  it('Test rounding halves (reversed)', () => {
    // Override values
    int = [505, 495];
    percentages = new Percentages(int);
    const corrected = percentages.corrected;
    // Expect the first value to be 51% and the second to be 49%
    expect(corrected[0]).toEqual(51);
    expect(corrected[1]).toEqual(49);
  });

});
