<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit43fce876d899f121d5b335733d6989de
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Postmark' => 
            array (
                0 => __DIR__ . '/..' . '/jjaffeux/postmark-inbound-php/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit43fce876d899f121d5b335733d6989de::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit43fce876d899f121d5b335733d6989de::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit43fce876d899f121d5b335733d6989de::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
