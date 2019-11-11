const Percentages = require('../../source/js/Percentages');
describe('Exception', () => {

  // Test if function throws an error if non-numeric array values are found
  it('Test console.error()', () => {
    
    const array = ['ABC'];
    spyOn(console, 'error').and.callFake(() => {
      const percentages = new Percentages(array);
      expect(console.error).toHaveBeenCalledWith(`Some values in the array ["${array}"] are not numeric.`);
      done();
    });

  });

});
