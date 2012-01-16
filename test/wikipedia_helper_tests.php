<?php
include_once('../lib/wikipedia_helper.php');

class Wikipedia_helperTest extends PHPUnit_Framework_TestCase
{
    protected $x;

    protected function setUp()
    {
        $this->x = new Wikipedia_helper('sapn2004@yahoo.co.uk');
    }

    public function testSingleSearchTermWithNonIntLimit()
    {
        $result = $this->x->getOpensearchResults(array('foo'), '10');
        $this->assertArrayHasKey('foo', $result);
        $this->assertCount(1, $result);
        $this->assertCount(10, $result['foo']);
    }

    public function testSingleSearchTermWithZeroLimit()
    {
        $result = $this->x->getOpensearchResults(array('foo'), 0);
        $this->assertArrayHasKey('foo', $result);
        $this->assertCount(1, $result);
        $this->assertCount(10, $result['foo']);
    }

    public function testSingleSearchTermWithExceededMaxLimit()
    {
        $result = $this->x->getOpensearchResults(array('foo'), 101);
        $this->assertArrayHasKey('foo', $result);
        $this->assertCount(1, $result);
        $this->assertCount(10, $result['foo']);
    }

    public function testSingleSearchTermWithDefaultLimit()
    {
        $result = $this->x->getOpensearchResults(array('foo'));
        $this->assertArrayHasKey('foo', $result);
        $this->assertCount(1, $result);
        $this->assertCount(10, $result['foo']);
    }

    public function testSingleSearchTermWithNonDefaultLimit()
    {
        $result = $this->x->getOpensearchResults(array('foo'), 2);
        $this->assertArrayHasKey('foo', $result);
        $this->assertCount(1, $result);
        $this->assertCount(2, $result['foo']);
    }

    public function testMultipleSearchTermsWithNonDefaultLimit()
    {
        $result = $this->x->getOpensearchResults(array('foo', 'bar'), 3);
        $this->assertArrayHasKey('foo', $result);
        $this->assertArrayHasKey('bar', $result);
        $this->assertCount(2, $result);
        $this->assertCount(3, $result['foo']);
        $this->assertCount(3, $result['bar']);
    }
}
/* End Of File: test/wikipedia_helper_tests.php
------------------------------------------------------------------------------*/
