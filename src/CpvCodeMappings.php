<?php

namespace Xterr\CpvCodes;

class CpvCodeMappings
{
    /**
     * @var string
     */
    private $baseDirectory;

    public function __construct(string $baseDirectory = null)
    {
        $this->baseDirectory = $baseDirectory ?? __DIR__ . '/../Resources';
    }

    public function getMapping(array $code, int version):? string {

    }
}
