<?php

namespace Vb\Bundle\AsseticCacheBustingBundle\Service\Asset;

use Symfony\Component\Asset\UrlPackage as BaseUrlPackage;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

class UrlPackage extends BaseUrlPackage
{
    /**
     * @var VersionStrategyInterface
     */
    private $customVersionStrategy;

    /**
     * @var bool
     */
    private $enabled;

    public function setVersionStrategy(VersionStrategyInterface $versionStrategy)
    {
        $this->customVersionStrategy = $versionStrategy;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    protected function getVersionStrategy()
    {
        if ($this->enabled) {
            return $this->customVersionStrategy;
        }

        return parent::getVersionStrategy();
    }
}
