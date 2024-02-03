<?php

namespace Gbenm\Phipes;

use Gbenm\Phipes\Contracts\Transformer;

abstract class TransformerFunction implements Transformer
{
    protected $fn;

    public function __construct(callable $fn)
    {
        $this->fn = $fn;
    }

    abstract public function transform(callable $fn, iterable $iterable): iterable;

    public function __invoke(iterable $iterable): iterable
    {
        return $this->transform($this->fn, $iterable);
    }
}
