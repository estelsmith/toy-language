<?php

namespace ToyLang\Core\Lexer\Token;

use ToyLang\Core\Util\Regex\Expression;

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
