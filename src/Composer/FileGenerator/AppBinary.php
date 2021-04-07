<?php

namespace Tover\Composer\FileGenerator;

class AppBinary extends AbstractFileGenerator
{
    protected static function getTemplatePath(): string
    {
        return 'templates/bin/toverphp.php.tpl';
    }

    protected static function getTargetPath(): string
    {
        return 'bin/toverphp';
    }

    protected static function getTemplateArgs(): array
    {
        $composerJson = static::getComposerJson();

        return [
            'packageVersion' => $composerJson->version,
            'phpVersionExpected' => $composerJson->require->php,
        ];
    }
}