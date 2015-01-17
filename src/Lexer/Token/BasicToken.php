<?php

namespace ToyLang\Lexer\Token;

class BasicToken implements Token
{
    /**
     * @var TokenType
     */
    private $tokenType;

    /**
     * @var string
     */
    private $value;

    public function __construct(TokenType $tokenType, $value)
    {
        $this->tokenType = $tokenType;
        $this->value = $value;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }

    public function getValue()
    {
        return $this->value;
    }
}
