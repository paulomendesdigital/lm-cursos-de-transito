<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit642b0723c72bbf81b54a15947d1bdca5
{
    public static $files = array (
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'd' => 
        array (
            'detran\\restsecurity\\' => 20,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'PagarMe\\Sdk\\' => 12,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'detran\\restsecurity\\' => 
        array (
            0 => __DIR__ . '/..' . '/restsecurity',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'PagarMe\\Sdk\\' => 
        array (
            0 => __DIR__ . '/..' . '/pagarme/pagarme-php/lib',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit642b0723c72bbf81b54a15947d1bdca5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit642b0723c72bbf81b54a15947d1bdca5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
