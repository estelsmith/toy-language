<?php

namespace ToyLang\Core\Lexer;

use ToyLang\Core\Lexer\Token\Token;
use ToyLang\Core\Lexer\Token\TokenType;

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
