<?php

namespace Gbenm\Phipes;

/** @param (callable($value, [$key]): mixed) $fn  */
function map(callable $fn): callable
{
    return function (iterable $iterable) use ($fn): iterable {
        foreach ($iterable as $key => $item) {
            yield $key => call_user_func($fn, $item, $key);
        }
    };
}

/** @param (callable($key, $value): [$key, $value]) $fn */
function mapKeyAndValue(callable $fn): callable
{
    return function (iterable $iterable) use ($fn): iterable {
        foreach ($iterable as $key => $item) {
            [$newKey, $newValue] = call_user_func($fn, $key, $item);
            yield $newKey => $newValue;
        }
    };
}

function ignoreKeys(): callable
{
    return function (iterable $iterable) {
        foreach ($iterable as $item) {
            yield $item;
        }
    };
}

/** @param (callable($value, [$key]): mixed) $predicate */
function filter(callable $predicate): callable
{
    return function (iterable $iterable) use ($predicate): iterable {
        foreach ($iterable as $key => $item) {
            if (call_user_func($predicate, $item, $key)) {
                yield $key => $item;
            }
        }
    };
}
