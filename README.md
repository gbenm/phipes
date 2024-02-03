# Phipes

Allows chaining transformations of iterables or building reusable pipelines, while also being easily extensible.

## Quickstart

### Some ways to transform an iterable
```php
// (temporal results) iterate many times over the same iterable
$result = array_filter($someIterable, $isOdd);
$result = array_map($mulByThree, $result);
$result = array_map($addTwo, $result);

// iterate many times over the same iterable
$result = array_map($addTwo, array_map($mulByThree, array_filter($someIterable, $isOdd)));

// imperative way
$result = [];
foreach ($someIterable as $item) {
    if ($isOdd($item)) {
        $result[] = $addTwo($mulByThree($item));
    }
}
```

### Using Phipes
Iterate only once

```php
use Phipes\Pipeline;

// delay computation
$result = Pipeline::for($someIterable)
    ->filter($isOdd)
    ->map($mulByThree)
    ->map($addTwo)
    ->asIterable(); // lazy

$result = Pipeline::for($someIterable)
    ->filter($isOdd)
    ->map($mulByThree)
    ->map($addTwo)
    ->asArray(); // start computing at this point

// Creating a pipeline

$pipeline = Pipeline::build()
    ->filter($isOdd)
    ->map($mulByThree)
    ->map($addTwo)
    ->build();

$results = $pipeline($someIterable);

$otherResults = $pipeline($someIterable2);
```

## Create a new transformer

```php
// by example the map function
/** @param (callable($value, [$key]): mixed) $fn  */
function map(callable $fn): callable
{
    return function (iterable $iterable) use ($fn): iterable {
        foreach ($iterable as $key => $item) {
            yield $key => call_user_func($fn, $item, $key);
        }
    };
}

// now you can use the pipe method or call the result
$result = Pipeline::for($someIterable)
    ->pipe(map(fn ($v) => $v + 1))
    ->asIterable(); // lazy

// alternative
$result = Pipeline::for($someIterable)
    (map(fn ($v) => $v + 1))
    ->asIterable(); // lazy
```
