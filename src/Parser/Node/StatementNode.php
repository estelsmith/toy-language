<?php

namespace ToyLang\Parser\Node;

class StatementNode implements Node
{
    /**
     * @var AssignmentNode|ExpressionNode
     */
    private $node;

    public function __construct(Node $node)
    {
        if (!($node instanceof AssignmentNode || $node instanceof ExpressionNode)) {
            throw new \Exception('$node must be an assignment or expression');
        }

        $this->node = $node;
    }

    /**
     * @return AssignmentNode|ExpressionNode
     */
    public function getNode()
    {
        return $this->node;
    }
}
