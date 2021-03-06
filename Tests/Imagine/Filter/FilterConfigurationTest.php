<?php

/*
 * This file is part of the `liip/LiipImagineBundle` project.
 *
 * (c) https://github.com/liip/LiipImagineBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Liip\ImagineBundle\Tests\Filter;

use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use Liip\ImagineBundle\Tests\AbstractTest;

/**
 * @covers \Liip\ImagineBundle\Imagine\Filter\FilterConfiguration
 */
class FilterConfigurationTest extends AbstractTest
{
    public function testSetAndGetFilter()
    {
        $config = array(
            'filters' => array(
                'thumbnail' => array(
                    'size' => array(180, 180),
                    'mode' => 'outbound',
                ),
            ),
            'cache' => 'web_path',
        );

        $filterConfiguration = new FilterConfiguration();
        $filterConfiguration->set('profile_photo', $config);

        $this->assertEquals($config, $filterConfiguration->get('profile_photo'));
    }

    public function testReturnAllFilters()
    {
        $filterConfiguration = new FilterConfiguration();
        $filterConfiguration->set('foo', array('fooConfig'));
        $filterConfiguration->set('bar', array('barConfig'));

        $filters = $filterConfiguration->all();

        $this->assertInternalType('array', $filters);

        $this->assertArrayHasKey('foo', $filters);
        $this->assertEquals(array('fooConfig'), $filters['foo']);

        $this->assertArrayHasKey('bar', $filters);
        $this->assertEquals(array('barConfig'), $filters['bar']);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Could not find configuration for a filter: thumbnail
     */
    public function testGetUndefinedFilter()
    {
        $filterConfiguration = new FilterConfiguration();
        $filterConfiguration->get('thumbnail');
    }

    public function testShouldGetSameConfigSetBefore()
    {
        $config = array(
            'quality' => 85,
            'format' => 'jpg',
            'filters' => array(
                'thumbnail' => array(
                    'size' => array(180, 180),
                    'mode' => 'outbound',
                ),
            ),
            'cache' => 'web_path',
        );

        $filterConfiguration = new FilterConfiguration();
        $filterConfiguration->set('profile_photo', $config);

        $this->assertEquals($config, $filterConfiguration->get('profile_photo'));
    }

    public function testGetConfigSetViaConstructor()
    {
        $filterConfiguration = new FilterConfiguration(array(
            'profile_photo' => array(),
            'thumbnail' => array(),
        ));

        $this->assertInternalType('array', $filterConfiguration->get('profile_photo'));
        $this->assertInternalType('array', $filterConfiguration->get('thumbnail'));
    }
}
