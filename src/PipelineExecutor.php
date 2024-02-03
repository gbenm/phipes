<?php

namespace Gbenm\Phipes;

class PipelineExecutor
{
    private $pipelineFunction;

    public function __construct(callable $pipelineFunction)
    {
        $this->pipelineFunction = $pipelineFunction;
    }

    public function streamFrom(iterable $iterable): Stream
    {
        return (new Stream($iterable))->pipe($this->pipelineFunction);
    }

    public function execute(iterable $iterable): iterable
    {
        return ($this->pipelineFunction)($iterable);
    }

    public function __invoke(iterable $iterable): iterable
    {
        return $this->execute($iterable);
    }
}
