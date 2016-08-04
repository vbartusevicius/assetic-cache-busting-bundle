<?php

namespace Vb\Bundle\AsseticCacheBustingBundle\Service;

class FileHashManager
{
    private $cacheFile;

    /**
     * @var array
     */
    private $hashmap;
    private $contentCrcMap;

    /**
     * @param string $cacheFile
     */
    public function __construct($cacheFile)
    {
        $this->cacheFile = $cacheFile;
        $this->contentCrcMap = array();

        if (stream_is_local($this->cacheFile) && file_exists($this->cacheFile)) {
            $this->hashmap = require $this->cacheFile;
        } else {
            $this->hashmap = array();
        }
    }

    /**
     * @param string $filename
     * @return string|null
     */
    public function getHash($filename)
    {
        return isset($this->hashmap[$filename]) ? $this->hashmap[$filename] : null;
    }

    /**
     * @param array $contentCrcMap
     */
    public function addContentCrcMap(array $contentCrcMap)
    {
        $this->contentCrcMap += $contentCrcMap;
    }

    public function dumpToCache()
    {
        $output = "<?php\n\nreturn " . var_export($this->contentCrcMap, true) . ";\n";
        file_put_contents($this->cacheFile, $output);
    }
}
