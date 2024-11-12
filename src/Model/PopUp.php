<?php

namespace Dynamic\Notifications\Model;

use Dynamic\Notifications\Extension\ContentDataExtension;
use Dynamic\Notifications\Extension\ExpirationDataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Cookie;
use SilverStripe\Forms\FieldList;
use SilverStripe\LinkField\Form\LinkField;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

/**
 * Class PopUp
 * @package Dynamic\Notifications\Model
 */
class PopUp extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Pop Up';

    /**
     * @var string
     */
    private static $plural_name = 'Pop Ups';

    /**
     * @var array|string[]
     */
    private static array $db = [
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Image' => Image::class,
        'ContentLink' => Link::class,
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Image',
    ];

    /**
     * @var array|array[]
     */
    private static array $searchable_fields = [
        'Title' => [
            'title' => 'Title',
        ],
        'Content' => [
            'title' => 'Content',
        ],
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image',
        'Title' => 'Title',
        'StartTime.Nice' => 'Starts',
        'EndTime.Nice' => 'Ends',
        'IsActive.Nice' => 'Active',
    ];

    /**
     * @var string
     */
    private static $table_name = 'Notification_PopUp';

    /**
     * @var array
     */
    private static array $extensions = [
        Versioned::class,
        ExpirationDataExtension::class,
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {

            $fields->dataFieldByName('Image')
                ->setAllowedFileCategories('image')
                ->setFolderName('Uploads/Notifications/PopUp')
                ->setIsMultiUpload(false);

            $fields->replaceField(
                'ContentLinkID',
                LinkField::create('ContentLink', 'Content Link')
            );

            $fields->dataFieldByName('Content')
                ->setRows(5);

            $fields->removeByName([
                'Sort',
            ]);

            $fields->addFieldsToTab(
                'Root.Main',
                [
                    $fields->dataFieldByName('StartTime'),
                    $fields->dataFieldByName('EndTime'),
                    $fields->dataFieldByName('Image'),
                    $fields->dataFieldByName('ContentLink'),
                ],
                'Content'
            );
        });

        return parent::getCMSFields();
    }

    /**
     * @return array|string|string[]
     */
    public function getCookieName(): array|string
    {
        return str_replace('&', 'and', str_replace(' ', '_', $this->Title));
    }

    /**
     * @return string|null
     */
    public function getPopUpCookie(): ?string
    {
        return Cookie::get($this->getCookieName());
    }
}
