<?php

namespace ToyLang\Parser\Node;

class ExpressionNode implements Node
{
    /**
     * @var ExpressionNode|NumberNode
     */
    private $leftExpression;

    /**
     * @var null|string
     */
    private $operator;

    /**
     * @var null|ExpressionNode
     */
    private $rightExpression;

    public function __construct(Node $leftExpression, $operator = null, ExpressionNode $rightExpression = null)
    {
        if (!($leftExpression instanceof NumberNode
            || $leftExpression instanceof IdentifierNode
            || $leftExpression instanceof ExpressionNode)
        ) {
            throw new \InvalidArgumentException('$leftExpression must be a number, identifier, or expression');
        }

        $this->leftExpression = $leftExpression;
        $this->operator = $operator;
        $this->rightExpression = $rightExpression;
    }

    /**
     * @return ExpressionNode|NumberNode
     */
    public function getLeftExpression()
    {
        return $this->leftExpression;
    }

    /**
     * @return null|string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return null|ExpressionNode
     */
    public function getRightExpression()
    {
        return $this->rightExpression;
    }
}
