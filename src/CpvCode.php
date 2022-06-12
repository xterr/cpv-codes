<?php

namespace Xterr\CpvCodes;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CpvCode
{
    public const TYPE_SUPPLY = 1;
    public const TYPE_WORKS = 2;
    public const TYPE_SERVICES = 3;

    public const VERSION_1 = 1;
    public const VERSION_2 = 2;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $numericCode;

    /**
     * @var int
     */
    private $version = self::VERSION_2;

    /**
     * @var CpvCode|null
     */
    private $parent;

    /**
     * @var Collection
     */
    private $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getNumericCode(): int
    {
        return $this->numericCode;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getParent(): ?CpvCode
    {
        return $this->parent;
    }

    /**
     * @return Collection|CpvCode[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function getShortCode(): string
    {
        return str_pad(rtrim(strstr($this->getCode(), '-', true), '0'), 2, '0');
    }

    public function getDivision(): string
    {
        return substr($this->getShortCode(), 0, 2);
    }

    public function isDivision(): bool
    {
        return strlen($this->getShortCode()) === 2;
    }

    public function getGroup(): string
    {
        return substr($this->getShortCode(), 0, 3);
    }

    public function isGroup(): bool
    {
        return strlen($this->getShortCode()) === 3;
    }

    public function getClass(): string
    {
        return substr($this->getShortCode(), 0, 4);
    }

    public function isClass()
    {
        return strlen($this->getShortCode()) === 4;
    }

    public function getCategory()
    {
        return substr($this->getShortCode(), 0, 5);
    }

    public function isCategory()
    {
        return strlen($this->getShortCode()) >= 5;
    }

    public function isSubcategory()
    {
        return strlen($this->getShortCode()) > 5;
    }
}
