# Percentages

![Bower Version](https://img.shields.io/bower/v/percentages.svg)

A small `CoffeeScript` / `JavaScript` function and `PHP` class for calculating percentages that solves rounding issues.

## How does it work

Both `Percentages.js` and `Percentages.class.php` use the principle of the [largest remainder method](https://en.wikipedia.org/wiki/Largest_remainder_method). Each percentage will be rounded down at first. After that, the script will add 1 percent to a rounded value if this value has the highest remainder. This process continues until a total of 100% is reached.

The function and class both return (1) absolute percentages, (2) rounded percentages and (3) the corrected percentages.

_Note: because the scripts loop through remainders until a total of 100% is reached, a difference of 1% can occur between two of the same values. See the last example below._

### Supported browsers (for JS)
Chrome, Firefox, Safari 4+, IE9+

## Installation

### Install with Bower

```
$ bower install percentages
```

### Or: include files

Include the `CoffeeScript`, `JavaScript` or `PHP` file.

## Examples

### JavaScript example

```javascript
// For comparison, the function returns all 3 types of percentages
var votes = [12, 30, 2, 7, 15],
    percentages = new Percentages(votes);

// Most likely, you only want to use the corrected percentages
// Use this instead:
var votes = [12, 30, 2, 7, 15],
    percentage = new Percentages(votes).corrected;
```

### PHP example

```php
// By default all 3 types will be returned
$votes = array(12, 30, 2, 7, 15);
$percentages = new Percentages();
$percentages = $percentages->get();

// If you only would like a specific type, use a parameter in the get() method
// Note that only "abs", "rounded" and "corrected" are valid
$percentages = $percentages->get("corrected");
```

### Rounding issue example

As said above: because the scripts loop through remainders until a total of 100% is reached, a difference of 1% can occur between two of the same values.

```php
$votes = array(1, 1, 1, 1, 1, 1);
$percentages = new Percentages();
$percentages = $percentages->get("corrected"); // output: array(17, 17, 17, 17, 16, 16)
```
