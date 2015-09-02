
/*
Percentages.js - v1.0
https://github.com/mzilverberg/Percentages
 */
var Percentages;

Percentages = function(values) {
  var methods, self;
  self = this;
  methods = {
    arraySum: function(data) {
      var i, j, _i, _len;
      i = 0;
      j = 0;
      for (_i = 0, _len = data.length; _i < _len; _i++) {
        j = data[_i];
        i += j;
      }
      return i;
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
        self.fixed.push(rounded);
        self.remainders.push(remainder);
        i++;
      }
      if (self.total !== 0) {
        methods.fixPercentages();
      }
    },
    fixPercentages: function() {
      var highestRemainder, index, roundedTotal;
      roundedTotal = methods.arraySum(self.fixed);
      while (roundedTotal < 100) {
        highestRemainder = Math.max.apply(Math, self.remainders);
        index = self.remainders.reduce((function(prev, curr, i, arr) {
          var x;
          return x = curr > arr[prev] ? i : prev;
        }), 0);
        self.fixed[index] = self.fixed[index] + 1;
        self.remainders[index] = -1;
        roundedTotal++;
      }
    }
  };
  self.optCount = values.length;
  self.total = methods.arraySum(values);
  self.abs = [];
  self.rounded = [];
  self.fixed = [];
  self.remainders = [];
  methods.calcPercentages();
  return {
    abs: self.abs,
    rounded: self.rounded,
    fixed: self.fixed
  };
};
