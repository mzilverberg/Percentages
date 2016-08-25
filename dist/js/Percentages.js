
/*
Percentages.js - v1.1.3
https://github.com/mzilverberg/Percentages
 */
var Percentages;

Percentages = function(values) {
  var methods, self;
  self = this;
  methods = {
    arraySum: function(data) {
      var i, j, sum, _i, _len;
      i = 0;
      j = 0;
      for (_i = 0, _len = data.length; _i < _len; _i++) {
        j = data[_i];
        i += j;
      }
      return sum = typeof i === "number" ? i : console.error("Percentages.js Error: Some of the values in the array are not numeric.");
    },
    calcPercentages: function() {
      var abs, i, remainder, rounded;
      i = 0;
      while (i < self.optCount) {
        abs = self.total === 0 ? 0 : (values[i] / self.total) * 100;
        rounded = Math.floor(abs);
        remainder = abs - rounded;
        self.abs.push(abs);
        self.rounded.push(rounded);
        self.corrected.push(rounded);
        self.remainders.push(remainder);
        i++;
      }
      if (self.total !== 0) {
        methods.fixPercentages();
      }
    },
    fixPercentages: function() {
      var highestRemainder, i, index, indexes, j, roundedTotal;
      roundedTotal = methods.arraySum(self.corrected);
      while (roundedTotal < 100) {
        highestRemainder = Math.max.apply(Math, self.remainders);
        index = self.remainders.reduce((function(prev, curr, i, arr) {
          var x;
          return x = curr > arr[prev] ? i : prev;
        }), 0);
        indexes = [];
        i = -1;
        while ((i = self.remainders.indexOf(highestRemainder, i + 1)) !== -1) {
          indexes.push(i);
        }
        if (indexes.length > 1) {
          j = 0;
          while (j < indexes.length) {
            if (self.rounded[indexes[j]] > self.rounded[index]) {
              index = indexes[j];
            }
            j++;
          }
        }
        self.corrected[index] = self.corrected[index] + 1;
        self.remainders[index] = -1;
        roundedTotal++;
      }
    }
  };
  self.optCount = values.length;
  self.total = methods.arraySum(values);
  self.abs = [];
  self.rounded = [];
  self.corrected = [];
  self.remainders = [];
  methods.calcPercentages();
  return {
    abs: self.abs,
    rounded: self.rounded,
    corrected: self.corrected
  };
};
