<?php

namespace Phipes;

class Pipeline
{
    private function __construct()
    {
    }

    public static function builder(): PipelineBuilder
    {
        return new PipelineBuilder();
    }

    /** @param array<(callable(iterable $iterable): iterable)> $transformers */
    public static function chain(array $transformers): PipelineExecutor
    {
        return (new PipelineBuilder($transformers))->build();
    }

    public static function for(iterable $iterable): Stream
    {
        return new Stream($iterable);
    }

    /**
     * throws \InvalidArgumentException when transformer is invalid
     * @param (callable(iterable $iterable): iterable) $transformer
     * */
    public static function assertValidTransformer($transformer): void
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
}
