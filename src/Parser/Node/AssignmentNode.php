<?php

namespace ToyLang\Parser\Node;

class AssignmentNode implements Node
{
    /**
     * @var IdentifierNode
     */
    private $identifier;

    /**
     * @var ExpressionNode
     */
    private $expression;

    public function __construct(IdentifierNode $identifier, ExpressionNode $expression)
    {
        $this->identifier = $identifier;
        $this->expression = $expression;
    }

    /**
     * @return IdentifierNode
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return ExpressionNode
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
