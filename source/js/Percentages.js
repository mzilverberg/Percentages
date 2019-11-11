class Percentages {
  constructor(values) {
    this.absolute = [];
    this.rounded = [];
    this.corrected = [];
    this.remainders = [];
    this.values = values;
    return this.init();
  }

  isNumericArray() {
    return this.values !== undefined && !this.values.some(isNaN);
  }

  sum(array) {
    return array.reduce((sum, x) => sum + x);
  }

  calc() {
    const sum = this.sum(this.values);
    for (let i = 0; i < this.values.length; i++) {
      let absolute = sum === 0 ? 0 : (this.values[i] / sum) * 100;
      let rounded = Math.floor(absolute);
      let remainder = absolute - rounded;
      this.absolute.push(absolute);
      this.rounded.push(rounded);
      this.corrected.push(rounded);
      this.remainders.push(remainder);
    }
  }

  rectify() {
    let sum = this.sum(this.corrected);
    while (sum < 100) {
      // Determine the largest remainder and get its array index.
      // If there are multiple values found, take the rounded percentage value into account.
      // E.g. rectify percentages of 49,5 and 50,5 to 49 and 51, respectively.
      const largestRemainder = Math.max(...this.remainders);
      const index = this.remainders.reduce((array, value, index) => {
        if (value === largestRemainder) array.push(index);
        return array;
      }, []).reduce((previous, current) => {
        return this.rounded[current] > this.rounded[previous] ? current : previous;
      });
      this.corrected[index]++;
      this.remainders[index] = -1;
      sum++;
    }
  }

  init() {
    // Don't handle arrays that contain any non-numeric values.
    if (!this.isNumericArray()) {
      const values = JSON.stringify(this.values);
      throw new Error(`Some values in the array ${values} are not numeric.`);
    }
    // Calculate and rectify percentages
    this.calc();
    this.rectify();
    // Return percentage values
    return {
      absolute: this.absolute,
      rounded: this.rounded,
      corrected: this.corrected,
      roundedSum: this.sum(this.rounded),
      correctedSum: this.sum(this.corrected)
    };
  }
}

module.exports = Percentages;
