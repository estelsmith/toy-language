<?php

namespace ToyLang\Lexer\Token;

interface Token
{
    /**
     * @return TokenType
     */
    public function getTokenType();

    /**
     * @return string
     */
    public function getValue();
}
