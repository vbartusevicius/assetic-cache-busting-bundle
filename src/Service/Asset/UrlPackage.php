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

    public function setVersionStrategy(VersionStrategyInterface $versionStrategy)
    {
        $this->customVersionStrategy = $versionStrategy;
    }

    protected function getVersionStrategy()
    {
        return $this->customVersionStrategy;
    }
}
