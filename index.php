<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use App\NodeVisitor\FuncVisitor;
use PhpParser\NodeTraverser;
use PhpParser\PrettyPrinter;
/*
$finder = new Finder();
$files = $finder->files()->in('/home/david/Bureau/www/test')->name('*.php');

foreach ($files as $f)
{
    $code = $f->getContents();
}
*/

$code = <<<'CODE'
<?php
mysql_query("SELECT * FROM societe WHERE id LIKE ('".$_SESSION['id_societe']."') LIMIT 1");

CODE;

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

$dumper = new NodeDumper;
$prettyPrinter = new PrettyPrinter\Standard;
var_dump( $prettyPrinter->prettyPrintFile($ast) );
var_dump($dumper->dump($ast));
$traverser = new NodeTraverser();
$traverser->addVisitor( new FuncVisitor );



$ast = $traverser->traverse($ast);
//var_dump($ast);




var_dump( $prettyPrinter->prettyPrintFile($ast) );

