<?php

namespace Tover\Composer\FileGenerator;

class AppBinary extends AbstractFileGenerator
{
    protected static function getTemplatePath(): string
    {
        return 'templates/bin/toverphp.php';
    }

    protected static function getTargetPath(): string
    {
        return 'bin/toverphp';
    }

    protected static function getTemplateArgs(): array
    {
        $packageInfo = static::getPackageInfo();

        return [
            'packageVersion' => $packageInfo->get('version'),
            'phpVersionExpected' => $packageInfo->get('require.php'),
        ];
    }
}