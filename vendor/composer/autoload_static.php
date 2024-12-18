<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb08cb796df626cbd42ba4afae4fd3620
{
    public static $prefixLengthsPsr4 = array (
        'k' => 
        array (
            'kartik\\date\\' => 12,
            'kartik\\base\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'kartik\\date\\' => 
        array (
            0 => __DIR__ . '/..' . '/kartik-v/yii2-widget-datepicker/src',
        ),
        'kartik\\base\\' => 
        array (
            0 => __DIR__ . '/..' . '/kartik-v/yii2-krajee-base/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb08cb796df626cbd42ba4afae4fd3620::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb08cb796df626cbd42ba4afae4fd3620::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb08cb796df626cbd42ba4afae4fd3620::$classMap;

        }, null, ClassLoader::class);
    }
}
