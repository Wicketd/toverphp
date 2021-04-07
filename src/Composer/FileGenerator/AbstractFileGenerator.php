<?php

namespace Tover\Composer\FileGenerator;

use Adbar\Dot;
use Composer\Factory;
use Webmozart\Assert\Assert;

abstract class AbstractFileGenerator
{
    const TARGET_DIR_MODE = 0755;
    const TEMPLATE_VAR_FORMAT = '{{%s}}';

    private static Dot $packageInfo;

    final public static function generate(): void
    {
        static::initProperties();

        $targetPath = static::getTargetPath();
        static::createTargetDirIfNeeded($targetPath);
    
        $output = static::processTemplate(static::getTemplatePath(), static::getTemplateArgs());
        static::saveOutput($targetPath, $output);
    }

    private static function initProperties(): void
    {
        static::$packageInfo = static::determinePackageInfo();
    }

    private static function determinePackageInfo(): Dot
    {
        $packageJson = @file_get_contents(Factory::getComposerFile());
        Assert::stringNotEmpty($packageJson);

        $packageJsonDecoded = json_decode($packageJson, true);
        Assert::notNull($packageJsonDecoded);

        return new Dot($packageJsonDecoded);
    }

    private static function createTargetDirIfNeeded(string $targetPath): void
    {
        $targetDir = dirname($targetPath);
        
        if (!file_exists($targetDir)) {
            mkdir($targetDir, static::TARGET_DIR_MODE, true);
        }
    }

    private static function processTemplate(string $templatePath, array $templateArgs): string
    {
        $template = @file_get_contents($templatePath);
        Assert::stringNotEmpty($template);

        return static::processTemplateArgs($template, $templateArgs);
    }

    private static function processTemplateArgs(string $template, array $templateArgs): string
    {
        foreach ($templateArgs as $key => $value) {
            $template = str_replace(
                sprintf(static::TEMPLATE_VAR_FORMAT, $key),
                $value,
                $template
            );
        }

        return $template;
    }

    private static function saveOutput(string $targetPath, string $output): void
    {
        $bytes = file_put_contents($targetPath, $output);
        Assert::positiveInteger($bytes);
    }

    final protected static function getPackageInfo(): Dot
    {
        return static::$packageInfo;
    }

    abstract protected static function getTemplatePath(): string;
    abstract protected static function getTargetPath(): string;
    abstract protected static function getTemplateArgs(): array;
}