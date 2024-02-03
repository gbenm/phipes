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

    /** @param (callable(iterable $iterable): iterable) $transformer */
    protected function assertValidTransformer($transformer): void
    {
        $reflectionFunction = new \ReflectionFunction($transformer);
        $oneParameter = $reflectionFunction->getNumberOfParameters() === 1;

        $oneParameterMessage = $oneParameter
            ? ''
            : "\t* transformer must have exactly one parameter";

        $parameterType = $reflectionFunction->getParameters()[0]->getType();
        $isParameterTypeIterable = isset($parameterType) && strval($parameterType) === 'iterable';

        $parameterTypeMessage = $isParameterTypeIterable
            ? ''
            : "\t* transformer must have explicitly typed parameter of type `iterable`";

        $returnType = $reflectionFunction->getReturnType();
        $isReturnTypeIterable = isset($returnType) && strval($returnType) === 'iterable';

        $returnTypeMessage = $isReturnTypeIterable
            ? ''
            : "\t* transformer must have explicitly typed return type of `iterable`";

        if ($oneParameter && $isParameterTypeIterable && $isReturnTypeIterable) {
            return;
        }

        $messages = implode("\n", array_filter([$oneParameterMessage, $parameterTypeMessage, $returnTypeMessage]));

        throw new \InvalidArgumentException(
            "Invalid transformer\n$messages\n"
        );
    }

    public function __call($name, $arguments)
    {
        return $this->pipe(("\\Gbenm\\Phipes\\$name")(...$arguments));
    }
}
