<?php

/*
 * This file is part of the `liip/LiipImagineBundle` project.
 *
 * (c) https://github.com/liip/LiipImagineBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Liip\ImagineBundle\Tests\Utility\Framework;

use Liip\ImagineBundle\Utility\Framework\SymfonyFramework;

/**
 * @covers \Liip\ImagineBundle\Utility\Framework\SymfonyFramework
 */
class SymfonyFrameworkTest extends \PHPUnit_Framework_TestCase
{
    public function testKernelComparisonForCurrentKernel()
    {
        if (1 !== preg_match('{(?<major>[0-9]+)\.(?<minor>[0-9]+)\.(?<patch>[0-9x]+)(?:-dev)?}', getenv('SYMFONY_VERSION'), $matches)) {
            $this->markTestSkipped('Requires environment variable SYMFONY_VERSION with value matching "[0-9].[0-9].[0-9x](-dev)?"');
        }

        list($major, $minor) = [$matches['major'], $matches['minor']];

        $this->assertTrue(SymfonyFramework::isKernelGreaterThanOrEqualTo($major, $minor));
        $this->assertFalse(SymfonyFramework::isKernelLessThan($major, $minor));
    }

    public function testIsKernelLessThan()
    {
        $this->assertTrue(SymfonyFramework::isKernelLessThan(100, 100, 100));
        $this->assertFalse(SymfonyFramework::isKernelLessThan(1, 1, 1));
    }

    public function testHasDirectContainerBuilderLogging()
    {
        if (SymfonyFramework::isKernelGreaterThanOrEqualTo(3, 3)) {
            $this->assertTrue(SymfonyFramework::hasDirectContainerBuilderLogging());
        } else {
            $this->assertFalse(SymfonyFramework::hasDirectContainerBuilderLogging());
        }
    }
}
