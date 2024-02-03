<?php

namespace Phipes;

use Phipes\Contracts\Assembler;

class PipelineBuilder extends Assembler
{
    private array $transformers = [];

    public function __construct(array $initialTransformers = [])
    {
        foreach ($initialTransformers as $transformer) {
            $this->pipe($transformer);
        }
    }

    public function __invoke(callable $transformer): self
    {
        return $this->pipe($transformer);
    }

    public function pipe(callable $transformer): self
    {
        Pipeline::assertValidTransformer($transformer);

        $this->transformers[] = $transformer;

        return $this;
    }

    public function build(): PipelineExecutor
    {
        return new PipelineExecutor($this->buildPipelineFunction());
    }

    private function buildPipelineFunction(): callable
    {
        $transformers = $this->transformers;
        return function (iterable $iterable) use ($transformers): iterable {
            $result = $iterable;

            foreach ($transformers as $transformer) {
                $result = $transformer($result);
            }

            return $result;
        };
    }
}
