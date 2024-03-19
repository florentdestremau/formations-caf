<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony'            => true,
        '@PSR12'              => true,
        '@PhpCsFixer'         => true,
        '@DoctrineAnnotation' => true,
        'array_syntax'        => ['syntax' => 'short'],
    ])
    ->setFinder($finder);
