<?php

declare(strict_types=1);

$stubs = require __DIR__ . '/../../vendor/xepozz/internal-mocker/src/stubs.php';

if (is_array($stubs) === false) {
    $stubs = [];
}

$stubs['array_splice'] = [
    'signatureArguments' => 'array &$array, int $offset, ?int $length = null, mixed $replacement = []',
    'arguments' => '$array, $offset, $length, $replacement',
];

return $stubs;
