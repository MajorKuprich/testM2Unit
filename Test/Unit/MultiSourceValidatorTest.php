<?php

namespace MK\Module\Test\Unit;

use MK\Module\Service\MultiSourceService;
use MK\Module\Validator\MultisourceValidator;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Quote\Model\Quote;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;

class MultiSourceValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $quoteMock = $this->getMockBuilder(Quote::class)
            ->disableOriginalConstructor()
            ->getMock();
        $multiSourceServiceMock = $this->getMockBuilder(MultiSourceService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $multiSourceServiceMock
            ->method('isMultisource')
            ->willReturn(true);
        $validatorMock = $this->getMockBuilder(MultisourceValidator::class)
            ->setConstructorArgs([$multiSourceServiceMock])
            ->getMock();

        self::assertTrue($multiSourceServiceMock->isMultisource($quoteMock));

        $objectManager = new ObjectManager($this);
        $validator = $objectManager->getObject(MultisourceValidator::class, [$multiSourceServiceMock]);
        $this->setAccessibleProperties($validator, [$multiSourceServiceMock]);

        $this->expectException(ValidatorException::class);

        $validator->validate($quoteMock);

//        $validatorMock->validate($quoteMock);
    }

    private function setAccessibleProperties(object $object, array $properties): void
    {
        $refClass = new ReflectionClass(get_class($object));
        $refProperties = $refClass->getProperties(ReflectionProperty::IS_PRIVATE);
        foreach ($refProperties as $key => $refProperty) {
            $refProperty->setAccessible(true);
            $refProperty->setValue($object, $properties[$key]);
        }
    }
}
