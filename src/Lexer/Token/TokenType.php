<?php

namespace ToyLang\Lexer\Token;

use ToyLang\Util\Regex\Expression;

interface TokenType
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return Expression
     */
    public function getExpression();

    /**
     * @param string $input
     * @return Token|null
     */
    public function match($input);
}
