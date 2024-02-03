<?php

namespace Gbenm\Phipes\Contracts;

/**
 * @method static map((callable($value, $key): mixed) $fn)
 * @method static mapKeyAndValue((callable($key, $value): [$key, $value]) $fn)
 */
abstract class Assembler
{
    abstract public function pipe(Transformer $transformer): self;
    abstract public function __invoke(Transformer $transformer): self;

    public function __call($name, $arguments)
    {
        return $this->pipe(("\\Gbenm\\Phipes\\$name")(...$arguments));
    }
}
