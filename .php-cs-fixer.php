<?php

if (!file_exists(__DIR__.'/src')) {
    exit(0);
}
$fileHeaderComment = <<<'EOF'
EOF;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER' => true,
        '@PER:risky' => true,
        'strict_param' => true,
        '@PHP71Migration' => true,
        '@PHPUnit75Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'modernize_strpos' => true,
        'binary_operator_spaces' => true,
        'linebreak_after_opening_tag' => true,
        'single_quote' => true,
        'date_time_immutable' => true,
        'cast_spaces' => true,
        'list_syntax' => ['syntax' => 'short'],
        'no_closing_tag' => true,
        'protected_to_private' => false,
        'native_constant_invocation' => ['strict' => false],
        'nullable_type_declaration_for_default_null_value' => ['use_nullable_type_declaration' => false],
        'no_superfluous_phpdoc_tags' => ['remove_inheritdoc' => true],
        'header_comment' => ['header' => $fileHeaderComment],
        'get_class_to_class_keyword' => true,
        'no_leading_import_slash' => true,
        'native_function_invocation' => false,

        'blank_line_before_statement' => [
            'statements' => [
                'continue',
                'declare',
                'default',
                'return',
                'throw',
                'try',
            ],
        ],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public_static',
                'property_protected_static',
                'property_private_static',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'phpunit',
                'method_public_static',
                'method_public_abstract_static',
                'method_protected_static',
                'method_protected_abstract_static',
                'method_private_static',
                'method_public',
                'method_public_abstract',
                'method_protected',
                'method_protected_abstract',
                'method_private',
            ],
        ],
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'length'],
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->in([
                __DIR__.'/src',
                __DIR__.'/tests',
            ])
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
    )
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/vendor/.php-cs-fixer.cache')
    ;
