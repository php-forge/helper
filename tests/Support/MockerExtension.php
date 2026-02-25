<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support;

use PHPUnit\Event\Test\{Finished, FinishedSubscriber, PreparationStarted, PreparationStartedSubscriber};
use PHPUnit\Event\TestSuite\{Started, StartedSubscriber};
use PHPUnit\Runner\Extension\{Extension, Facade, ParameterCollection};
use PHPUnit\TextUI\Configuration\Configuration;
use Xepozz\InternalMocker\{Mocker, MockerState};

/**
 * PHPUnit extension that registers internal-function mocks for test execution.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class MockerExtension implements Extension
{
    /**
     * Registers event subscribers that initialize and reset mock state.
     */
    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $facade->registerSubscribers(
            new class implements StartedSubscriber {
                public function notify(Started $event): void
                {
                    MockerExtension::load();
                }
            },
            new class implements PreparationStartedSubscriber {
                public function notify(PreparationStarted $event): void
                {
                    MockerState::resetState();
                }
            },
            new class implements FinishedSubscriber {
                public function notify(Finished $event): void
                {
                    MockerState::resetState();
                }
            },
        );
    }

    /**
     * Loads configured function mocks and snapshots their initial state.
     */
    public static function load(): void
    {
        $mocks = [
            [
                'namespace' => 'PHPForge\\Helper',
                'name' => 'array_splice',
            ],
            [
                'namespace' => 'PHPForge\\Helper',
                'name' => 'explode',
            ],
            [
                'namespace' => 'PHPForge\\Helper',
                'name' => 'random_int',
            ],
            [
                'namespace' => 'PHPForge\\Helper',
                'name' => 'preg_split',
            ],
            [
                'namespace' => 'PHPForge\\Helper',
                'name' => 'str_contains',
            ],
        ];

        $mocksPath = __DIR__ . '/../../runtime/.phpunit.cache/internal-mocker/mocks.php';
        $stubPath = __DIR__ . '/internal-mocker-stubs.php';

        $mocker = new Mocker($mocksPath, $stubPath);
        $mocker->load($mocks);

        MockerState::saveState();
    }
}
