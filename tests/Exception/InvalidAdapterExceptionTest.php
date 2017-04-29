<?php

namespace Acclimate\Container\Test\Exception;

use Acclimate\Container\Exception\InvalidAdapterException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Acclimate\Container\Exception\InvalidAdapterException
 */
class InvalidAdapterExceptionTest extends TestCase
{
    public function getDataForFactoryTest()
    {
        $msgTpl = 'There is no container adapter registered to handle %s.';

        return [
            [new \SplQueue, sprintf($msgTpl, 'SplQueue objects')],
            [5, sprintf($msgTpl, 'integer variables')],
            ['foo', sprintf($msgTpl, 'string variables')],
            [[], sprintf($msgTpl, 'array variables')],
            [$this, sprintf($msgTpl, 'Acclimate\Container\Test\Exception\InvalidAdapterExceptionTest objects')],
        ];
    }

    /**
     * @dataProvider getDataForFactoryTest
     */
    public function testFactoryMethodProducesException($adaptee, $message)
    {
        $exception = InvalidAdapterException::fromAdaptee($adaptee);
        $this->assertEquals($message, $exception->getMessage());
    }
}
