<?php

namespace Phipes;

use Phipes\Contracts\Assembler;
use Generator;

class Stream extends Assembler
{
    private Generator $genesis;
    private iterable $currentIterable;
    private iterable $source;

    public function __construct(iterable $iterable)
    {
        $this->source = $iterable;
        $this->genesis = $this->createGenesis();
        $this->currentIterable = $this->proxy($this->genesis);
    }

    private function createGenesis(): Generator
    {
        /** @var iterable $iterable */
        $iterable = yield;

        foreach ($iterable as $key => $item) {
            yield $key => $item;
        }
    }

    private function proxy(Generator $generator): iterable
    {
        while ($generator->valid()) {
            yield $generator->key() => $generator->current();
            $generator->next();
        }
    }

    public function __invoke(callable $transformer): self
    {
        return $this->pipe($transformer);
    }

    public function pipe(callable $transformer): self
    {
        Pipeline::assertValidTransformer($transformer);

        $this->currentIterable = $transformer($this->currentIterable);
        return $this;
    }

    public function consume(callable $consumer): void
    {
        $this->genesis->send($this->source);
        $consumer($this->currentIterable);
    }

    public function asIterable(): iterable
    {
        $this->genesis->send($this->source);
        return $this->currentIterable;
    }

    public function asArray(): array
    {
        return iterator_to_array($this->asIterable());
    }

    public function first()
    {
        foreach ($this->asIterable() as $item) {
            return $item;
        }
    }

    public function last()
    {
        $last = null;
        foreach ($this->asIterable() as $item) {
            $last = $item;
        }
        return $last;
    }
}
