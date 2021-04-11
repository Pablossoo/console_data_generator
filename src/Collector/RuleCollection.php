<?php

namespace App\Collector;

final class RuleCollection
{
    private iterable $rules;

    public function __construct(iterable $rules)
    {
        $this->rules = $rules;
    }

    public function getRules(): iterable
    {
        return iterator_to_array($this->rules);
    }
}
