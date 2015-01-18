<?php

namespace ToyLang\Parser\Node;

class ProgramNode implements Node
{
    /**
     * @var ExpressionNode
     */
    private $expression;

    public function __construct(ExpressionNode $expression)
    {
        $this->expression = $expression;
    }

    /**
     * @return ExpressionNode
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
