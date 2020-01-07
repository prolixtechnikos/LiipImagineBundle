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

use League\Flysystem\FilesystemInterface;
use Liip\ImagineBundle\Exception\Binary\Loader\NotLoadableException;
use Liip\ImagineBundle\Model\Binary;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface;
use Symfony\Component\Mime\MimeTypes;

class FlysystemLoader implements LoaderInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    public function __construct(
        FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function find($path)
    {
        if ($this->filesystem->has($path) === false) {
            throw new NotLoadableException(sprintf('Source image "%s" not found.', $path));
        }
        $mimeTypes = new MimeTypes();
        $mimeType = $this->filesystem->getMimetype($path);

        return new Binary(
            $this->filesystem->read($path),
            $mimeType,
            $mimeTypes->guess($mimeType)
        );
    }
}
