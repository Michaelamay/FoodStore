<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfd20a7218d2608da09196a9ab8760f4d
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Appwrite\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Appwrite\\' => 
        array (
            0 => __DIR__ . '/..' . '/appwrite/appwrite/src/Appwrite',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfd20a7218d2608da09196a9ab8760f4d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfd20a7218d2608da09196a9ab8760f4d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfd20a7218d2608da09196a9ab8760f4d::$classMap;

        }, null, ClassLoader::class);
    }
}
