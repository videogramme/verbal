<?php

require_once 'vendor/autoload.php';

use MarkWilson\VerbalExpression;
use MarkWilson\VerbalExpression\Matcher;

// initialise verbal expression instance
$verbalExpression = new VerbalExpression();

// URL matcher
$verbalExpression->startOfLine()
                 ->then('http')
                 ->maybe('s')
                 ->then('://')
                 ->maybe('www.')
                 ->anythingBut(' ')
                 ->endOfLine();

// compile expression - returns ^(http)(s)?(\:\/\/)(www\.)?([^\ ]*)$
$verbalExpression->compile();

// perform match
preg_match($verbalExpression, 'http://www.google.com'); // returns 1
// or
$matcher = new Matcher();
$matcher->isMatch($verbalExpression, 'http://www.google.com'); // returns true




/*
exemple 2
Nesting expressions

$innerExpression = new VerbalExpression();
$innerExpression->word();

$outerExpression = new VerbalExpression();
$outerExpression->startOfLine()
                ->find($innerExpression)
                ->then($innerExpression)
                ->endOfLine();

// returns ^(\w+)(\w+)$
$outerExpression->compile();
*/



/*
exemple 3

// disable sub pattern capture
$verbalExpression->disableSubPatternCapture()->word(); // (?:\w+)
// or
$verbalExpression->word(false); // (?:\w+)

// equivalent to (\w+)(?:\w+)(?:\w+)(\w+)
$verbalExpression->word()
                 ->disableSubPatternCapture()
                 ->word()
                 ->word()
                 ->enableSubPatternCapture()
                 ->word();
*/