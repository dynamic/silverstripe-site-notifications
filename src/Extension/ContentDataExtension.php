<?php

namespace Dynamic\Notifications\Extension;

use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class ContentDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Title' => [
            'title' => 'Title',
        ],
        'Content' => [
            'title' => 'Content'
        ]
    ];

    /**
     * @var bool
     */
    private static $versioned_gridfield_extensions = true;

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->dataFieldByName('Content')
            ->setRows(5);
    }
}
