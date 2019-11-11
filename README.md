# Percentages

![NPM Version](https://img.shields.io/npm/v/percentages)

A small `CoffeeScript` / `JavaScript` function and `PHP` class for calculating percentages that solves rounding issues.

## How does it work

Both `Percentages.js` and `Percentages.class.php` use the principle of the [largest remainder method](https://en.wikipedia.org/wiki/Largest_remainder_method). Each percentage will be rounded down at first. After that, the script will add 1 percent to a rounded value if this value has the highest remainder. This process continues until a total of 100% is reached.

The function and class both return (1) absolute percentages, (2) rounded percentages and (3) the corrected percentages, as well as (4) the sum of the rounded percentages and (5) the sum of the corrected percentages, which should always be `100`.

_Note: because the scripts loop through remainders until a total of 100% is reached, a difference of 1% can occur between two of the same values. See the last example below._

## Installation

### Install with NPM

```
$ npm install percentages
```

### Include files

Include the `JavaScript` or `PHP` file.

## Examples

### JavaScript example

```javascript
// For comparison reasons, the function returns more than the corrected percentages
const Percentages = require('percentages');
const votes = [12, 30, 2, 7, 15];
const percentages = new Percentages(votes);

// Most likely, you only want to use the corrected percentages
// Use this instead:
const Percentages = require('percentages');
const votes = [12, 30, 2, 7, 15],
const votesPercentages = new Percentages(votes).corrected;
```

### PHP example

```php
// For comparison reasons, the function returns more than the corrected percentages
require_once('path/to/Percentages.class.php');
$votes = array(12, 30, 2, 7, 15);
$percentages = new Percentages();
$percentages = $percentages->get();

// If you only would like a specific type, use a parameter in the get() method
// Note that only "absolute", "rounded", "corrected", "roundedSum", and "correctedSum" are valid
// The value of "correctedSum" should always be 100 (obviously), and the value of "roundedSum" differs based on input
$percentages = $percentages->get("corrected");
```

### Rounding issue example

As said above: because the scripts loop through remainders until a total of 100% is reached, a difference of 1% can occur between two of the same values.

```php
$votes = array(1, 1, 1, 1, 1, 1);
$percentages = new Percentages();
$percentages = $percentages->get("corrected"); // output: array(17, 17, 17, 17, 16, 16)
```

## Testing

Run automated tests with command line.

### JavaScript

_This requires [jasmine](https://github.com/jasmine/jasmine), which is installed as a devDependency._
```
$ npm run test
```

### PHP

_This requires [PHPUnit](https://github.com/sebastianbergmann/phpunit)._

```
$ cd tests
$ phpunit
```
