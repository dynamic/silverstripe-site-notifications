<?php

namespace Dynamic\Notifications\Model;

use Dynamic\Notifications\Extension\ContentDataExtension;
use Dynamic\Notifications\Extension\DismissibleExtension;
use Dynamic\Notifications\Extension\ExpirationDataExtension;
use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Cookie;
use SilverStripe\Dev\Deprecation;
use SilverStripe\Forms\FieldList;
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
    private static $extensions = [
        Versioned::class,
        ContentDataExtension::class,
        ExpirationDataExtension::class,
        DismissibleExtension::class,
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {

            $fields->dataFieldByName('Image')
                ->setAllowedFileCategories('image')
                ->setFolderName('Uploads/Notifications/PopUp')
                ->setIsMultiUpload(false);

            $fields->replaceField(
                'ContentLinkID',
                LinkField::create('ContentLinkID', 'Content Link')
            );

            $fields->dataFieldByName('Content')
                ->setRows(5);

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
                    $fields->dataFieldByName('Image'),
                    $fields->dataFieldByName('ContentLinkID'),
                ],
                'Content'
            );
        }

        return $fields;
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
    public function getPopUpCookie()
    {
        Deprecation::notice('1.3', 'getPopUpCookie() is deprecated. Use getDismissibleCookie().');
        
        return $this->getDismissibleCookie();
    }
}
