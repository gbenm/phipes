<?php

namespace Gbenm\Phipes;

function map(callable $fn): callable
{
    return function ($iterable) use ($fn) {
        foreach ($iterable as $key => $item) {
            yield $key => call_user_func($fn, $item, $key);
        }
    };
}

function mapKeyAndValue(callable $fn): callable
{
    return function ($iterable) use ($fn) {
        foreach ($iterable as $key => $item) {
            [$newKey, $newValue] = call_user_func($fn, $key, $item);
            yield $newKey => $newValue;
        }
    };
}

function ignoreKeys(): callable
{
    return function ($iterable) {
        foreach ($iterable as $item) {
            yield $item;
        }
    };
}

function filter(callable $predicate): callable
{
    return function ($iterable) use ($predicate) {
        foreach ($iterable as $key => $item) {
            if (call_user_func($predicate, $item, $key)) {
                yield $key => $item;
            }
        }
    };
}
