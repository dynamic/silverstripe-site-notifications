<?php

namespace Dynamic\Notifications\Model;

use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use Dynamic\Notifications\Extension\ContentDataExtension;
use Dynamic\Notifications\Extension\ExpirationDataExtension;
use Dynamic\Notifications\Traits\Dismissible;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

/**
 * Class Violator
 * @package Dynamic\Notifications\Model
 */
class Violator extends DataObject
{
    use Dismissible;
    
    /**
     * @var string
     */
    private static $singular_name = 'Violator';

    /**
     * @var string
     */
    private static $plural_name = 'Violators';

    /**
     * @var array
     */
    private static $db = [
        'Sort' => 'Int',
    ];

    /**
     * @var string
     */
    private static $default_sort = 'Sort';

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title' => 'Title',
        'StartTime.Nice' => 'Starts',
        'EndTime.Nice' => 'Ends',
        'IsActive.Nice' => 'Active',
    ];

    /**
     * @var array
     */
    private static $extensions = [
        Versioned::class,
        ContentDataExtension::class,
        ExpirationDataExtension::class,
    ];

    /**
     * @var string
     */
    private static $table_name = 'Notification_Violator';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName([
                'Sort',
            ]);
        });

        $fields = parent::getCMSFields();

        if ($fields->dataFieldByName('StartTime')) {
            $fields->addFieldsToTab(
                'Root.Main',
                [
                    $fields->dataFieldByName('StartTime'),
                    $fields->dataFieldByName('EndTime'),
                ],
                'Content'
            );
        }

        return $fields;
    }
}
