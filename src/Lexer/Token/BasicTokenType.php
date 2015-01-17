<?php

namespace ToyLang\Lexer\Token;

use ToyLang\Util\Regex\Expression;

class BasicTokenType implements TokenType
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Expression
     */
    private $expression;

    public function __construct($name, Expression $expression)
    {
        $this->name = $name;
        $this->expression = $expression;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getExpression()
    {
        return $this->expression;
    }

    public function match($input)
    {
        $result = $this->expression->match($input);

        if ($result) {
            return new BasicToken($this, $result->getMatches()[0]);
        }

        return null;
    }
}
