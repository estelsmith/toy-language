<?php

namespace ToyLang\Parser;

use ToyLang\Core\Lexer\Token\Token;
use ToyLang\Parser\Node\Expression\ExpressionNode;
use ToyLang\Parser\Node\NumberNode;
use ToyLang\Parser\Node\ProgramNode;

class LanguageParser
{
    /**
     * @var Token[]
     */
    private $tokens;

    /**
     * @param Token[] $tokens
     * @return ProgramNode
     */
    public function parse($tokens)
    {
        if (!$tokens) {
            throw new \InvalidArgumentException('Cannot parse an empty tokens tree');
        }

        $this->tokens = $tokens;

        return $this->parseProgram();
    }

    protected function discard()
    {
        array_shift($this->tokens);
    }

    protected function skipWhitespace()
    {
        $tokens = &$this->tokens;
        $continue = true;

        while ($continue && $tokens) {
            $token = $tokens[0];

            if ($token->getTokenType()->getName() === 'WHITESPACE') {
                array_shift($tokens);
            } else {
                $continue = false;
            }
        }
    }

    /**
     * @return Token
     */
    protected function peek()
    {
        $this->skipWhitespace();
        return $this->tokens[0];
    }

    /**
     * @param string $expectedType
     * @return Token
     * @throws \Exception
     */
    protected function match($expectedType)
    {
        $token = $this->peek();

        $currentTokenType = $token->getTokenType()->getName();

        if ($currentTokenType === $expectedType) {
            $this->discard();
            return $token;
        }

        throw new \Exception(sprintf(
            'Expected token type "%s", got "%s" instead',
            $expectedType,
            $currentTokenType
        ));
    }

    /**
     * @return ProgramNode
     */
    protected function parseProgram()
    {
        $expression = $this->parseExpression();
        $this->match('STATEMENT_TERMINATOR');

        return new ProgramNode($expression);
    }

    protected function parseExpression()
    {
        return $this->parseEqualityExpression();
    }

    protected function parseEqualityExpression()
    {
        $leftExpression = $this->parseAdditiveExpression();
        $operator = null;
        $rightExpression = null;

        $nextToken = $this->peek();
        $tokenType = $nextToken->getTokenType()->getName();

        if ($tokenType !== 'EQUALITY_OPERATOR') {
            return $leftExpression;
        } else {
            $operator = $this->match('EQUALITY_OPERATOR')->getValue();
            $rightExpression = $this->parseEqualityExpression();

            return new ExpressionNode($leftExpression, $operator, $rightExpression);
        }
    }

    protected function parseAdditiveExpression()
    {
        $leftExpression = $this->parseMultiplicativeExpression();
        $operator = null;
        $rightExpression = null;

        $nextToken = $this->peek();
        $tokenType = $nextToken->getTokenType()->getName();

        if ($tokenType !== 'ADDITIVE_OPERATOR') {
            return $leftExpression;
        } else {
            $operator = $this->match('ADDITIVE_OPERATOR')->getValue();
            $rightExpression = $this->parseAdditiveExpression();

            return new ExpressionNode($leftExpression, $operator, $rightExpression);
        }
    }

    protected function parseMultiplicativeExpression()
    {
        $leftExpression = $this->parseParenExpression();
        $operator = null;
        $rightExpression = null;

        $nextToken = $this->peek();
        $tokenType = $nextToken->getTokenType()->getName();

        if ($tokenType !== 'MULTIPLICATIVE_OPERATOR') {
            return $leftExpression;
        } else {
            $operator = $this->match('MULTIPLICATIVE_OPERATOR')->getValue();
            $rightExpression = $this->parseMultiplicativeExpression();

            return new ExpressionNode($leftExpression, $operator, $rightExpression);
        }
    }

    protected function parseParenExpression()
    {
        $nextToken = $this->peek();
        $tokenType = $nextToken->getTokenType()->getName();

        switch ($tokenType) {
            case 'NUMBER':
                $this->discard();
                return new ExpressionNode(new NumberNode($nextToken->getValue()));
                break;
            case 'OPEN_PAREN':
                $this->discard();
                $expression = $this->parseExpression();
                $this->match('CLOSE_PAREN');

                return $expression;
                break;
            default:
                throw new \Exception(sprintf(
                    'Expected NUMBER or OPEN_PAREN, got "%s" instead',
                    $tokenType
                ));
                break;
        }
    }
}
