<?php

namespace ToyLang\Parser\Node;

class ProgramNode implements Node
{
    /**
     * @var StatementNode
     */
    private $statement;

    public function __construct(StatementNode $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @return StatementNode
     */
    public function getStatement()
    {
        return $this->statement;
    }
}
