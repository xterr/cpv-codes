<?php

namespace Xterr\CpvCodes\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Xterr\CpvCodes\CpvCode;
use Xterr\CpvCodes\CpvCodesFactory;

class CpvCodesTest extends TestCase
{
    public function testIterator(): void
    {
        $isoCodes = new CpvCodesFactory();
        $cpvCodes = $isoCodes->getCodes();

        foreach ($cpvCodes as $cpvCode) {
            static::assertInstanceOf(
                CpvCode::class,
                $cpvCode
            );
        }

        static::assertIsArray($cpvCodes->toArray());
        static::assertGreaterThan(0, count($cpvCodes));
    }

    public function testGetByCodeAndVersion(): void
    {
        $isoCodes = new CpvCodesFactory();
        $cpvCode = $isoCodes->getCodes()->getByCodeAndVersion('31532700-1', CpvCode::VERSION_2);
        static::assertInstanceOf(CpvCode::class, $cpvCode);

        static::assertEquals('31532700-1', $cpvCode->getCode());
        static::assertEquals(CpvCode::VERSION_2, $cpvCode->getVersion());
        static::assertEquals(CpvCode::TYPE_SUPPLY, $cpvCode->getType());
        static::assertEquals('31532700', $cpvCode->getNumericCode());
        static::assertEquals('Lamp covers', $cpvCode->getName());
        static::assertEquals('315327', $cpvCode->getShortCode());
        static::assertEquals('31532700-1_' . CpvCode::VERSION_2, $cpvCode->getCodeVersion());

        $cpvCode = $isoCodes->getCodes()->getByCodeAndVersion('03451300-9', CpvCode::VERSION_2);
        static::assertInstanceOf(CpvCode::class, $cpvCode);

        static::assertEquals('03451300-9', $cpvCode->getCode());
        static::assertEquals(CpvCode::VERSION_2, $cpvCode->getVersion());
        static::assertEquals(CpvCode::TYPE_SUPPLY, $cpvCode->getType());
        static::assertEquals('3451300', $cpvCode->getNumericCode());
        static::assertEquals('Shrubs', $cpvCode->getName());
        static::assertEquals('034513', $cpvCode->getShortCode());
    }

    public function testCount(): void
    {
        $isoCodes = new CpvCodesFactory();
        static::assertEquals(17777, $isoCodes->getCodes()->count());
    }
}
