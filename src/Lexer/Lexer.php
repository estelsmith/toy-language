<?php

namespace ToyLang\Lexer;

use ToyLang\Lexer\Token\Token;
use ToyLang\Lexer\Token\TokenType;

interface Lexer
{
    /**
     * @param TokenType $tokenType
     * @return $this
     */
    public function addTokenType(TokenType $tokenType);

    /**
     * @param TokenType[] $tokenTypes
     * @return $this
     */
    public function addTokenTypes($tokenTypes);

    /**
     * @param $input
     * @return Token[]
     */
    public function tokenize($input);
}
