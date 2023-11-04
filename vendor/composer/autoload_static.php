<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf05faae3dde9378c6fa2911694a56154
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Gbenm\\Pihpes\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Gbenm\\Pihpes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf05faae3dde9378c6fa2911694a56154::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf05faae3dde9378c6fa2911694a56154::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf05faae3dde9378c6fa2911694a56154::$classMap;

        }, null, ClassLoader::class);
    }
}