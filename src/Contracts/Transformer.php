<?php

namespace Gbenm\Phipes\Contracts;

interface Transformer
{
    public function __invoke(iterable $iterable): iterable;
}
