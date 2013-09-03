<?php

namespace Jeremeamia\Acclimate\Test\Adapter;

use Jeremeamia\Acclimate\Adapter\SymfonyContainerAdapter;
use Symfony\Component\DependencyInjection\Container;

/**
 * @covers \Jeremeamia\Acclimate\Adapter\SymfonyContainerAdapter
 */
class SymfonyContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    private $symfonyContainer;

    public function setUp()
    {
        $this->symfonyContainer = new Container();
        $this->symfonyContainer->set('array_iterator', new \ArrayIterator(range(1, 5)));
    }

    public function testCanCreateAdapter()
    {
        $adapter = new SymfonyContainerAdapter($this->symfonyContainer);

        $this->assertTrue($adapter->has('array_iterator'));
        $arrayIterator = $adapter->get('array_iterator');
        $this->assertEquals(array(1, 2, 3, 4, 5), iterator_to_array($arrayIterator));

        $this->assertFalse($adapter->has('foo'));
        $this->assertNull($adapter->get('foo'));
    }
}
