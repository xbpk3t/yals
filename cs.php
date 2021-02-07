<?php

// PHP-CS-Fixer Version 2.8
return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@Symfony' => true,
        'align_multiline_comment' => true, //每行多行DocComments必须有一个星号[PSR-5]，并且必须与第一行对齐
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'cast_spaces' => ['space' => 'single'],
        'concat_space' => ['spacing' => 'one'],
        'combine_consecutive_issets' => true, // 当多个 isset 通过&&连接的时候，合并处理
        'combine_consecutive_unsets' => true, // 当多个 unset 使用的时候，合并处理
        'compact_nullable_typehint' => true, // ???
        'dir_constant' => true, // 用__DIR__代替dirname()
        'declare_equal_normalize' => ['space' => 'single'], // 声明 等于号 两边的空格
        'single_line_comment_style' => true, // 单行注释用//而不是/**/
        'header_comment' => [
            'header' => '', //头部注释
        ],
        'is_null' => true, // 用null === $ var替换is_null（$ var）表达式
        'mb_str_functions' => true, // 一些函数默认加mb_
        'native_function_casing' => true, // PHP定义的函数应使用正确的大小写进行调用
        'no_blank_lines_after_class_opening' => true, // 去掉class类后面的空行
        'no_blank_lines_after_phpdoc' => true, // phpdoc 后面不应该有空行
//        'no_blank_lines_before_namespace' => true,// 命名空间之间没有空行，和单行的规则冲突
        'no_extra_blank_lines' => [
            'tokens' => [
                'return', 'extra',
            ],
        ],
        'no_empty_comment' => true, // 不应该存在空注释
        'no_empty_phpdoc' => true, // 不应该存在空的 phpdoc
        'no_empty_statement' => true, // 不应该存在空的结构体
        'no_leading_namespace_whitespace' => true, // 在声明命令空间的时候，不允许有前置空格
        'no_singleline_whitespace_before_semicolons' => true, // 禁止在关闭分号前使用单行空格
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_in_blank_line' => true,
        'normalize_index_brace' => true,
        'no_null_property_initialization' => true,
        'no_unreachable_default_argument_value' => true,
        'no_short_echo_tag' => true, //把所有的<?php echo 换成<?=
        'no_trailing_whitespace' => true, //删除非空行末尾的尾随空格
        'no_unused_imports' => true, //去掉未使用的引入类
        'ordered_class_elements' => true,
        'ordered_imports' => [
            'sortAlgorithm' => 'length', //引入的类，按照长短排序
        ],
        'phpdoc_no_empty_return' => false,
        'php_unit_test_class_requires_covers' => true,
        'phpdoc_order' => true,
        'protected_to_private' => true, //protected变成private
        'self_accessor' => true, //在当前类中使用 self 代替类名；
        'single_quote' => true,
        'space_after_semicolon' => true,
        'whitespace_after_comma_in_array' => true,
        'random_api_migration' => [
            'replacements' => [
                'getrandmax' => 'mt_getrandmax',
                'rand' => 'mt_rand',
                'srand' => 'mt_srand',
            ],
        ],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    );
