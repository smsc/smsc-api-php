<?php
$project_name = 'Smsc';
$config = require __DIR__.'/../../vendor/reyesoft/ci/php/rules/php-cs-fixer.dist.php';

// rules override
$rules = array_merge(
    $config->getRules(),
    [
        'return_assignment' => false,    // problem on ObjectsEloquentBuilder
        'php_unit_test_class_requires_covers' => false,
        'php_unit_internal_class' => false,
    ]
);

return $config
    ->setRules($rules)
    ->setFinder(
        PhpCsFixer\Finder::create()
        ->in('./src')
        ->notPath('./bootstrap/*.php')
        ->in('./tests')
    );
