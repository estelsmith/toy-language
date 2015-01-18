Toy Language
============
Just making a toy language compiler and interpreter in PHP.

Language Definition
-------------------
The language is whitespace insignificant.

EBNF Grammar:
```
any_character = ? any character ?;
letter = ? regular expression [a-zA-Z] ?;
digit = ? regular expression [0-9] ?;

return_keyword = "return";

assign_operator = "=";
equality_operator = "==" | "!=";
additive_operator = "+" | "-";
multiplicative_operator = "*" | "/";
open_paren = "(";
close_paren = ")";
number = digit, { digit };
statement_terminator = ";";

identifier = letter, { letter | digit | "_" }; (* @TODO: Actually use identifiers somewhere *)
string = "'", any_character - "'", "'"; (* @TODO: Actually use strings somewhere *)

equality_expression = additive_expression, [ equality_operator, additive_expression ];
additive_expression = multiplicative_expression, [ additive_operator, multiplicative_expression ];
multiplicative_expression = paren_expression, [ multiplicative_operator, paren_expression ];
paren_expression = open_paren, expression, close_paren | number | identifier;
expression = equality_expression;

return = return_keyword, expression;
assignment = identifier, assign_operator, expression;

statement = return | assignment | expression, statement_terminator;

program = statement;
```

Syntactically valid program:
```
(1 + 3) * 2;
```

License
-------
```
Copyright (c) 2015 Estel Smith

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
