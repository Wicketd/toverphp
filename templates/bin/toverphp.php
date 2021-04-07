#!/usr/bin/env php
<?php

/**
 * This file is auto-generated.
 *
 * @version {{packageVersion}}
 */

require __DIR__ . '/../vendor/autoload.php';

use Composer\Semver\Semver;

if (!Semver::satisfies(\PHP_VERSION, '{{phpVersionExpected}}')) {
    printf(
        "ToverPHP requires PHP %s to run, found %s. Exiting.\n",
        '{{phpVersionExpected}}',
        \PHP_VERSION
    );
    exit(1);
}

echo "do stuff\n";