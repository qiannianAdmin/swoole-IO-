<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit660beec7579de2fb027215680f9f1dac
{
    public static $prefixLengthsPsr4 = array (
        'Q' => 
        array (
            'Qiannian\\Io\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Qiannian\\Io\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit660beec7579de2fb027215680f9f1dac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit660beec7579de2fb027215680f9f1dac::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
