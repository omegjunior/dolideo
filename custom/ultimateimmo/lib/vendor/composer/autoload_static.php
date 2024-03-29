<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit338aacd791fc52d7097fd02e539e9df9
{
    public static $prefixLengthsPsr4 = array ( 
        'M' => 
        array (
            'Michelf\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Michelf\\' => 
        array (
            0 => __DIR__ . '/..' . '/michelf/php-markdown/Michelf',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit338aacd791fc52d7097fd02e539e9df9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit338aacd791fc52d7097fd02e539e9df9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit338aacd791fc52d7097fd02e539e9df9::$classMap;

        }, null, ClassLoader::class);
    }
}
