<?php

namespace Xterr\CpvCodes;

use Symfony\Contracts\Translation\TranslatorInterface;

class CpvCodesFactory
{
    /**
     * @var string
     */
    private $baseDirectory;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(string $baseDirectory = null, TranslatorInterface $translator = null)
    {
        $this->baseDirectory = $baseDirectory;
        $this->translator = $translator;
    }

    public function getCodes(): CpvCodes
    {
        return new CpvCodes($this->baseDirectory, $this->translator);
    }
}
