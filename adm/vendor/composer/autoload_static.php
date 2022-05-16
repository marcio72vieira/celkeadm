<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdd8d71849ca34c7447b921d6cf5554c8
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdd8d71849ca34c7447b921d6cf5554c8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdd8d71849ca34c7447b921d6cf5554c8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdd8d71849ca34c7447b921d6cf5554c8::$classMap;

        }, null, ClassLoader::class);
    }
}
