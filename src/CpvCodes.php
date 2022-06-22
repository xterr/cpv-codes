<?php

namespace Xterr\CpvCodes;

use Symfony\Contracts\Translation\TranslatorInterface;

class CpvCodes implements \Iterator, \Countable
{
    /**
     * @var string
     */
    private $baseDirectory;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    private $data = [];

    private $index = [];

    public function __construct(string $baseDirectory = null, TranslatorInterface $translator = null)
    {
        $this->baseDirectory = $baseDirectory ?? __DIR__ . '/../Resources';
        $this->translator = $translator;
    }

    public function getByCodeAndVersion(string $code, int $version = CpvCode::TYPE_SERVICES): ?CpvCode
    {
        return $this->_find('code_version', [$code, $version]);
    }

    public function current(): CpvCode
    {
        return $this->arrayToEntry(current($this->data));
    }

    public function next(): void
    {
        next($this->data);
    }

    public function key(): ?int
    {
        return key($this->data);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind(): void
    {
        $this->_loadData();
        reset($this->data);
    }

    protected function arrayToEntry(array $entry): CpvCode
    {
        $closure = \Closure::bind(static function () use ($entry) {
            $cpvCode = new CpvCode();
            $cpvCode->name = $entry['name'];
            $cpvCode->code = $entry['code'];
            $cpvCode->type = $entry['type'];
            $cpvCode->numericCode = $entry['numericCode'];
            $cpvCode->version = $entry['version'];
            $cpvCode->parentCode = $entry['parent'];
            $cpvCode->codeVersion = implode('_', [$entry['code'], $entry['version']]);

            return $cpvCode;
        }, null, CpvCode::class);

        return $closure();
    }

    public function count(): int
    {
        $this->_loadData();

        return count($this->data);
    }

    public function toArray(): array
    {
        return iterator_to_array($this);
    }

    private function _loadData(): void
    {
        if (!empty($this->data)) {
            return;
        }

        $this->data = json_decode(file_get_contents($this->baseDirectory . DIRECTORY_SEPARATOR . 'cpvCodes.json'), true);
    }

    private function _find(string $key, $value): ?CpvCode
    {
        $this->_buildIndex();

        return $this->index[$key][is_array($value) ? implode('_', $value) : $value] ?? null;
    }

    private function _buildIndex(): void
    {
        if (!empty($this->index)) {
            return;
        }

        $this->_loadData();

        foreach ($this->data as $entry) {
            $this->index['code_version'][implode('_', [$entry['code'], $entry['version']])] = $this->arrayToEntry($entry);
        }
    }
}
