<?php

namespace App\NodeVisitor;

use PhpParser\NodeVisitorAbstract;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;

class FuncVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node) {


        if ($node instanceof FuncCall){

            foreach ($node->name->parts as $p)
            {
                if (preg_match("/^(mysql|mysqli)_/i", $p))
                {
                    $node->name = new Name('$pdo->prepare');
                }
            }
        }
    }
}
