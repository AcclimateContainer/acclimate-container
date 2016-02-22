<?php

namespace Acclimate\Container\Test\Exception;

use Acclimate\Container\Exception\ContainerException;

/**
 * Test fixture that implements toString behavior
 */
class Dummy
{
    public function __toString()
    {
        return 'dummy';
    }
}

/**
 * @covers \Acclimate\Container\Exception\ContainerException
 */
class ContainerExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function getDataForFactoryTest()
    {
        $msgTpl = 'An %s occurred when attempting to retrieve the "%s" entry from the container.%s';

        $strId = 'foo';
        $objId = new Dummy;
        $badId = new \SplQueue;
        $regEx = new \RuntimeException('TEST');
        $nilEx = null;

        return [
            [$strId, $nilEx, sprintf($msgTpl, 'error', 'foo', '')],
            [$objId, $nilEx, sprintf($msgTpl, 'error', 'dummy', '')],
            [$badId, $nilEx, sprintf($msgTpl, 'error', '?', '')],
            [$strId, $regEx, sprintf($msgTpl, 'RuntimeException', 'foo', ' Message: TEST')],
        ];
    }

    /**
     * @dataProvider getDataForFactoryTest
     */
    public function testFactoryMethodProducesException($id, $prev, $message)
    {
        $exception = ContainerException::fromPrevious($id, $prev);
        $this->assertEquals($message, $exception->getMessage());
    }
}
