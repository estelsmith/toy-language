<?php

namespace ToyLang\Parser\Node;

class NumberNode implements Node
{
    /**
     * @var int
     */
    private $value;

    public function __construct($value)
    {
        $this->value = (int)$value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
}
