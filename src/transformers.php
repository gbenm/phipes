<?php

namespace Gbenm\Phipes;

use Gbenm\Phipes\Contracts\Transformer;

function map(callable $fn): Transformer
{
    return new class ($fn) extends TransformerFunction {
        public function transform(callable $fn, iterable $iterable): iterable
        {
            foreach ($iterable as $key => $item) {
                yield $key => call_user_func($fn, $item, $key);
            }
        }
    };
}

function mapKeyAndValue(callable $fn): Transformer
{
    return new class ($fn) extends TransformerFunction {
        public function transform(callable $fn, iterable $iterable): iterable
        {
            foreach ($iterable as $key => $item) {
                [$newKey, $newValue] = call_user_func($fn, $key, $item);
                yield $newKey => $newValue;
            }
        }
    };
}

function ignoreKeys(): Transformer
{
    return new class implements Transformer {
        public function __invoke(iterable $iterable): iterable
        {
            foreach ($iterable as $item) {
                yield $item;
            }
        }
    };
}

function filter(callable $predicate): Transformer
{
    return new class ($predicate) extends TransformerFunction {
        public function transform(callable $fn, iterable $iterable): iterable
        {
            foreach ($iterable as $key => $item) {
                if (call_user_func($fn, $item, $key)) {
                    yield $key => $item;
                }
            }
        }
    };
}
