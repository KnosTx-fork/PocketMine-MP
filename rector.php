<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    // Set direktori yang akan diperbaiki
    $rectorConfig->paths([
        __DIR__ . '/src',
    ]);

    // Pilih level PHP atau aturan standar PHPStan
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_80,
        LevelSetList::DEAD_CODE,
        LevelSetList::CODE_QUALITY,
    ]);

    // Aturan lain bisa ditambahkan di sini
};
