<?php

/*
 * This file is part of the `liip/LiipImagineBundle` project.
 *
 * (c) https://github.com/liip/LiipImagineBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Liip\ImagineBundle\Binary\Loader;

use Liip\ImagineBundle\Binary\Locator\LocatorInterface;
use Liip\ImagineBundle\Model\FileBinary;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface;
use Symfony\Component\Mime\MimeTypes;

class FileSystemLoader implements LoaderInterface
{
    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @param LocatorInterface          $locator
     * @param string[]                  $rootPaths
     */
    public function __construct(
        LocatorInterface $locator,
        array $rootPaths = []
    ) {
        $this->locator = $locator;
        $this->locator->setOptions(['roots' => $rootPaths]);
    }

    /**
     * {@inheritdoc}
     */
    public function find($path)
    {
        $mimeTypes = new MimeTypes();
        $path = $this->locator->locate($path);
        $mime = $mimeTypes->guessMimeType($path);

        return new FileBinary($path, $mime, $mimeTypes->getExtensions($mime));
    }
}
