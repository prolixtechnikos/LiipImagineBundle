<?php

/*
 * This file is part of the `liip/LiipImagineBundle` project.
 *
 * (c) https://github.com/liip/LiipImagineBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Liip\ImagineBundle\DependencyInjection\Factory\Loader;

use Liip\ImagineBundle\DependencyInjection\Factory\ChildDefinitionTrait;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

abstract class AbstractLoaderFactory implements LoaderFactoryInterface
{
    use ChildDefinitionTrait;

    /**
     * @var string
     */
    protected static $namePrefix = 'liip_imagine.binary.loader';

    /**
     * @return ChildDefinition|DefinitionDecorator
     */
    final protected function getChildLoaderDefinition()
    {
        return $this->getChildDefinition(sprintf('%s.prototype.%s', static::$namePrefix, $this->getName()));
    }

    /**
     * @param string           $name
     * @param Definition       $definition
     * @param ContainerBuilder $container
     *
     * @return string
     */
    final protected function setTaggedLoaderDefinition($name, Definition $definition, ContainerBuilder $container)
    {
        $definition->addTag(static::$namePrefix, [
            'loader' => $name,
        ]);

        $container->setDefinition(
            $id = sprintf('%s.%s', static::$namePrefix, $name),
            $definition
        );

        return $id;
    }
}
