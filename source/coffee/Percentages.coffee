###
Percentages.js - v1.1.1
https://github.com/mzilverberg/Percentages
###

Percentages = (values) ->

    # Store object
    self = @

    # Methods
    methods =

        # Calculate sum of array values
        arraySum: (data) ->
            i = 0
            j = 0
            i += j for j in data
            # Throw an error if non-numeric array values are found
            sum = if typeof i is "number" then i else console.error "Percentages.js Error: Some of the values in the array are not numeric."

        # Calculate percentages
        calcPercentages: ->
            i = 0
            while i < self.optCount
                # Calculate percentages and remainder
                abs = if self.total is 0 then 0 else (values[i] / self.total) * 100
                rounded = Math.floor(abs)
                remainder = abs - rounded
                # Store percentages and remainder in arrays
                self.abs.push(abs)
                self.rounded.push(rounded)
                self.corrected.push(rounded)
                self.remainders.push(remainder)
                i++
            methods.fixPercentages() if self.total isnt 0
            return

        # Fix rounded percentages if rounded total does not equal 100%
        fixPercentages: ->
            roundedTotal = methods.arraySum(self.corrected)
            while roundedTotal < 100
                # Get highest remainder
                highestRemainder = Math.max.apply(Math, self.remainders)
                # Get index of highest remainder
                index = self.remainders.reduce(((prev, curr, i, arr) ->
                    x = if curr > arr[prev] then i else prev
                ), 0)
                # Update rounded percentage
                self.corrected[index] = self.corrected[index] + 1
                # Unset current highest remainder
                self.remainders[index] = -1
                # Update total value
                roundedTotal++;
            return

    # Store amount of options
    self.optCount = values.length
    # Calculate total value count by adding up
    self.total = methods.arraySum(values)
    # Create new arrays for percentages and remainders
    self.abs = []
    self.rounded = []
    self.corrected = []
    self.remainders = []
    # Calculate percentages
    methods.calcPercentages()

    # Return calculated percentages
    {
        abs: self.abs
        rounded: self.rounded
        corrected: self.corrected
    }
