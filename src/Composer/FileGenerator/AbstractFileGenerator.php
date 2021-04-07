<?php

namespace Tover\Composer\FileGenerator;

use Composer\Factory;
use Webmozart\Assert\Assert;

abstract class AbstractFileGenerator
{
    private static \stdClass $composerJson;

    public final static function generate(): void
    {
        static::$composerJson = json_decode(file_get_contents(Factory::getComposerFile()));  

        $targetPath = static::getTargetPath();
        $targetDir = dirname($targetPath);

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $output = @file_get_contents(static::getTemplatePath());
        Assert::stringNotEmpty($output);

        foreach (static::getTemplateArgs() as $key => $value) {
            $output = str_replace(sprintf('{{%s}}', $key), $value, $output);
        }

        $bytes = file_put_contents(static::getTargetPath(), $output);
        Assert::positiveInteger($bytes);
    }

    final protected static function getComposerJson(): \stdClass
    {
        return static::$composerJson;
    }

    abstract protected static function getTemplatePath(): string;
    abstract protected static function getTargetPath(): string;
    abstract protected static function getTemplateArgs(): array;
}