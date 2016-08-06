<?php

namespace Vb\Bundle\AsseticCacheBustingBundle\Service;

use Assetic\Asset\AssetCollectionInterface;
use Assetic\Asset\AssetInterface;
use Assetic\Factory\AssetFactory;
use Assetic\Factory\Worker\WorkerInterface;
use Assetic\Util\VarUtils;

class HashWorker implements WorkerInterface
{
    private $fileHashManager;
    private $hashAlgorithm;
    private $basePath;
    private $asseticVariables;
    private $enabled;

    /**
     * @param FileHashManager $fileHashManager
     * @param string $hashAlgorithm
     * @param string $basePath
     * @param array $asseticVariables
     * @param bool $enabled
     */
    public function __construct(
        FileHashManager $fileHashManager,
        $hashAlgorithm,
        $basePath,
        array $asseticVariables,
        $enabled
    ) {
        $this->fileHashManager = $fileHashManager;
        $this->hashAlgorithm = $hashAlgorithm;
        $this->basePath = $basePath;
        $this->asseticVariables = $asseticVariables;
        $this->enabled = $enabled;
    }

    /**
     * @param AssetInterface $asset
     * @param AssetFactory $factory
     *
     * @return AssetInterface|null
     */
    public function process(AssetInterface $asset, AssetFactory $factory)
    {
        if (php_sapi_name() !== 'cli' || !$this->enabled) {
            return null;
        }

        $crcMap = $this->calculateAssetChecksum($asset);
        $this->fileHashManager->addContentCrcMap($crcMap);

        if ($asset instanceof AssetCollectionInterface) {
            foreach ($asset as $leaf) {
                $crcMap = $this->calculateAssetChecksum($leaf);
                $this->fileHashManager->addContentCrcMap($crcMap);
            }
        }

        $this->fileHashManager->dumpToCache();
    }

    private function calculateAssetChecksum(AssetInterface $asset)
    {
        $crcMap = [];
        $relativeTargetPath = $asset->getTargetPath();

        $combinations = VarUtils::getCombinations($asset->getVars(), $this->asseticVariables);

        foreach ($combinations as $combination) {
            $asset->setValues($combination);

            $target = rtrim($this->basePath, '/') . '/' . $relativeTargetPath;
            $target = str_replace('_controller/', '', $target);
            $target = VarUtils::resolve($target, $asset->getVars(), $asset->getValues());

            $crcMap[basename($target)] = hash($this->hashAlgorithm, $asset->dump());
        }

        return $crcMap;
    }
}
