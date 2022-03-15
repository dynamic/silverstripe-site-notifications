<?php

namespace Dynamic\Notifications\Extension;

use SilverStripe\Control\Cookie;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class DismissibleExtension extends DataExtension
{
    /**
     * @var string[]
     */
    private static $db = [
        'IsDismissible' => 'Boolean',
    ];

    /**
     * @var bool[]
     */
    private static $defaults = [
        'IsDismissible' => true,
    ];

    /**
     * @param FieldList $fields
     * @return void
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->insertAfter(
            'Title',
            CheckboxField::create('IsDismissible')
                ->setTitle('Hide after dismissing')
        );
    }

    /**
     * @return mixed
     */
    public function getCookieName()
    {
        return str_replace('&', 'and', str_replace(' ', '_', $this->Title));
    }

    /**
     * @return mixed
     */
    public function getDismissibleCookie()
    {
        return Cookie::get($this->getCookieName());
    }
}
