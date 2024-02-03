<?php

namespace Gbenm\Phipes;

class Pipeline
{
    private function __construct()
    {
    }

    // public static function builder(): PipelineBuilder
    // {
    //     return new self();
    // }

    public static function for(iterable $iterable): Stream
    {
        return new Stream($iterable);
    }
}
