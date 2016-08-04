<?php

namespace Vb\Bundle\AsseticCacheBustingBundle\Service\Asset;

use Symfony\Component\Asset\PathPackage as BasePathPackage;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

class PathPackage extends BasePathPackage
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
