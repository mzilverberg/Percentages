# Percentages

**Important**: this repository is no longer actively maintained. It has been transferred to https://github.com/frisfruitig/Percentages.

![NPM Version](https://img.shields.io/npm/v/percentages)

A small `JavaScript` and `PHP` class for calculating percentages that solves rounding issues.

## How does it work

Both `Percentages.js` and `class-percentages.php` use the principle of the [largest remainder method](https://en.wikipedia.org/wiki/Largest_remainder_method). Each percentage will be rounded down at first. After that, the script will add 1 percent to a rounded value if this value has the highest remainder. This process continues until a total of 100% is reached.

Both the JS and PHP classes return (1) absolute percentages, (2) rounded percentages and (3) the corrected percentages, as well as (4) the sum of the rounded percentages and (5) the sum of the corrected percentages, which should always be `100`.

_Note: because the scripts loop through remainders until a total of 100% is reached, a difference of 1% can occur between two of the same input values. See the last example below._

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
require_once 'path/to/class-percentages.php';
use MZ\Percentages as Percentages;

$votes         = array( 12, 30, 2, 7, 15 );
$percentages   = new Percentages( $votes );
$everything    = $percentages->get();

// The class supports methods to get the absolute, rounded or corrected percentages values directly, too.
$corrected     = $percentages->get_corrected();

// Additionally, it can return the sum of the rounded and corrected percentages. Obviously, the latter is always `100`. For example:
$corrected_sum = $percentages->get_corrected_sum();
```

### Rounding issue example

As said above: because the scripts loop through remainders until a total of 100% is reached, a difference of 1% can occur between two of the same input values.

```php
// Note: `require_once` and `use` omitted in this example.
$votes       = array( 1, 1, 1, 1, 1, 1 );
$percentages = new Percentages();
$percentages = $percentages->get_corrected(); // output: array( 17, 17, 17, 17, 16, 16 )
```

### Bundled example

This project comes with an example that relies on both the PHP and JavaScript class. To run it, create a host through software like XAMPP or MAMP and run the following command:

```
npm run example
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
