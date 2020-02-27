<?php

namespace Dynamic\Notifications\Test\Model;

use Dynamic\Notifications\Model\Violator;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

/**
 * Class ViolatorTest
 * @package Dynamic\Notifications\Test\Model
 */
class ViolatorTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture(Violator::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
