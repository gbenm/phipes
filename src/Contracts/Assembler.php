<?php

namespace Gbenm\Phipes\Contracts;

/**
 * @method static map((callable($value, [$key]): mixed) $fn)
 * @method static mapKeyAndValue((callable($key, $value): [$key, $value]) $fn)
 * @method static filter((callable($value, [$key]): mixed) $predicate)
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
        $function = "\\Gbenm\\Phipes\\$name";

        if (!function_exists($function)) {
            throw new \BadMethodCallException("Method $name does not exist");
        }

        return $this->pipe($function(...$arguments));
    }
}
