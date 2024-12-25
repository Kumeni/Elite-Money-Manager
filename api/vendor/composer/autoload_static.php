<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5494c13cf010d379fcf4af29bb6fdddb
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Courier\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Courier\\' => 
        array (
            0 => __DIR__ . '/..' . '/ctrlaltdylan/courier/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5494c13cf010d379fcf4af29bb6fdddb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5494c13cf010d379fcf4af29bb6fdddb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5494c13cf010d379fcf4af29bb6fdddb::$classMap;

        }, null, ClassLoader::class);
    }
}
