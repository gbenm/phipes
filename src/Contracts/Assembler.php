<?php

namespace Gbenm\Phipes\Contracts;

/**
 * @method static map((callable($value, $key): mixed) $fn)
 * @method static mapKeyAndValue((callable($key, $value): [$key, $value]) $fn)
 * @method static filter((callable($value, $key): mixed) $fn)
 * @method static ignoreKeys()
 */
abstract class Assembler
{
    /** @param (callable(iterable $iterable): iterable) $transformer */
    abstract public function pipe(callable $transformer): self;

    /** @param (callable(iterable $iterable): iterable) $transformer */
    abstract public function __invoke(callable $transformer): self;

    public function __call($name, $arguments)
    {
        return $this->pipe(("\\Gbenm\\Phipes\\$name")(...$arguments));
    }
}
