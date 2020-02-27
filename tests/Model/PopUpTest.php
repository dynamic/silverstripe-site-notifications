<?php

namespace Dynamic\Notifications\Test\Model;

use Dynamic\Notifications\Model\PopUp;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

/**
 * Class PopUpTest
 * @package Dynamic\Notifications\Test\Model
 */
class PopUpTest extends SapphireTest
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
        $object = $this->objFromFixture(PopUp::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
