<?php

namespace ToyLang\Lexer;

use ToyLang\Core\Lexer\Lexer;
use ToyLang\Core\Lexer\Token\BasicTokenType;
use ToyLang\Core\Lexer\Token\TokenType;
use ToyLang\Core\Util\Regex\Expression;

class LanguageLexer implements Lexer
{
    /**
     * @var Lexer
     */
    private $lexer;

    public function __construct(Lexer $lexer)
    {
        $lexer->addTokenTypes([
            new BasicTokenType('EQUALITY_OPERATOR', new Expression('/^(==|\!=)/')),
            new BasicTokenType('ADDITIVE_OPERATOR', new Expression('/^(\+|-)/')),
            new BasicTokenType('MULTIPLICATIVE_OPERATOR', new Expression('/^(\*|\/)/')),
            new BasicTokenType('OPEN_PAREN', new Expression('/^(\()/')),
            new BasicTokenType('CLOSE_PAREN', new Expression('/^(\))/')),
            new BasicTokenType('NUMBER', new Expression('/^([0-9]+)/')),
            new BasicTokenType('IDENTIFIER', new Expression('/^([a-zA-Z][a-zA-Z0-9_]+)/')),
            new BasicTokenType('STATEMENT_TERMINATOR', new Expression('/^(;)/')),
            new BasicTokenType('WHITESPACE', new Expression('/^(\s+)/')),
            new BasicTokenType('UNKNOWN', new Expression('/^(.)/'))
        ]);

        $this->lexer = $lexer;
    }

    public function addTokenType(TokenType $tokenType)
    {
        $this->lexer->addTokenType($tokenType);

        return $this;
    }

    public function addTokenTypes($tokenTypes)
    {
        $this->lexer->addTokenTypes($tokenTypes);

        return $this;
    }

    public function tokenize($input)
    {
        return $this->lexer->tokenize($input);
    }
}
