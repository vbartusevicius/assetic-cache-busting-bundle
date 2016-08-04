<?php

namespace Vb\Bundle\AsseticCacheBustingBundle\Service;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

class AssetHashVersionStrategy implements VersionStrategyInterface
{
    private $fileHashManager;

    public function __construct(FileHashManager $fileHashManager)
    {
        $this->fileHashManager = $fileHashManager;
    }

    /**
     * Returns the asset version for an asset.
     *
     * @param string $path A path
     *
     * @return string The version string
     */
    public function getVersion($path)
    {
        $hash = $this->fileHashManager->getHash(pathinfo($path, PATHINFO_BASENAME));
        return $hash ?: '';
    }

    /**
     * Applies version to the supplied path.
     *
     * @param string $path A path
     *
     * @return string The versionized path
     */
    public function applyVersion($path)
    {
        $hash = $this->getVersion($path);
        return !empty($hash) ? sprintf('%s?v=%s', $path, urlencode($hash)) : $path;
    }
}
