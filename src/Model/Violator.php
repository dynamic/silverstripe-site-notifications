<?php

namespace Dynamic\Notifications\Model;

use Dynamic\Notifications\Extension\ContentDataExtension;
use Dynamic\Notifications\Extension\ExpirationDataExtension;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Versioned\Versioned;
use SilverStripe\View\Parsers\URLSegmentFilter;

/**
 * Class Violator
 * @package Dynamic\Notifications\Model
 */
class Violator extends DataObject
{
    /**
     * @var string
     */
    private static string $singular_name = 'Violator';

    /**
     * @var string
     */
    private static string $plural_name = 'Violators';

    /**
     * @var array
     */
    private static array $db = [
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'Sort' => 'Int',
        'ShowOnce' => 'Boolean',
        'CookieName' => 'Varchar(255)',
    ];

    /**
     * @var array|true[]
     */
    private static array $indexes = [
        'CookieName' => true,
    ];

    /**
     * @var string
     */
    private static $default_sort = 'Sort';

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
    private static array $summary_fields = [
        'Title' => 'Title',
        'StartTime.Nice' => 'Starts',
        'EndTime.Nice' => 'Ends',
        'IsActive.Nice' => 'Active',
    ];

    /**
     * @var array
     */
    private static array $extensions = [
        Versioned::class,
        ExpirationDataExtension::class,
    ];

    /**
     * @var string
     */
    private static string $table_name = 'Notification_Violator';

    /**
     * @return FieldList
     */
    public function getCMSFields(): FieldList
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName([
                'Sort',
                'ShowOnce',
                'CookieName',
            ]);

            $fields->addFieldToTab(
                'Root.Main',
                FieldGroup::create(
                    DropdownField::create('ShowOnce')
                        ->setTitle('Show Once')
                        ->setSource([
                            0 => 'No (Will display even if the user closes alert)',
                            1 => 'Yes (Will no longer display after user closes alert)',
                        ]),
                    TextField::create('CookieName')
                        ->setTitle('Cookie Name')
                        ->setDescription('Optional. Set a cookie name if the alert shows once, a cookie name will generate if none given.')
                )->setName('cookie_settings')
                    ->setDescription('Should this alert show only once? If "yes" you can set a name, or a cookie name will be generated. The cookie name will be have spaces and special characters removed.'),
                'Title'
            );

            $fields->addFieldsToTab(
                'Root.Main',
                [
                    $fields->dataFieldByName('StartTime'),
                    $fields->dataFieldByName('EndTime'),
                ],
                'Content'
            );
        });

        return parent::getCMSFields();
    }

    /**
     * @return void
     */
    protected function onBeforeWrite(): void
    {
        parent::onBeforeWrite();

        if ($this->ShowOnce && !$this->CookieName) {
            $this->CookieName = $this->filterCookieName($this->Title);
        } elseif ($this->ShowOnce) {
            $this->CookieName = $this->filterCookieName($this->CookieName);
        }
    }

    /**
     * @return ValidationResult
     */
    public function validate(): ValidationResult
    {
        $validationResult = parent::validate();

        if (!$this->validCookieName()) {
            $validationResult->addFieldError('CookieName', 'Cookie name already used by another record.', 'validation');
        }

        return $validationResult;
    }

    /**
     * @return bool
     */
    public function validCookieName(): bool
    {
        $result = Violator::get()->filter('CookieName', $this->filterCookieName($this->CookieName));

        if ($this->exists() && $this->isInDB()) {
            $result = $result->exclude('ID', $this->ID);
        }

        if ($result->count() === 0) {
            $result = PopUp::get()->filter('CookieName', $this->filterCookieName($this->CookieName));
        }

        return $result->count() === 0;
    }

    /**
     * @param $cookieName
     * @return string
     */
    public function filterCookieName($cookieName): string
    {
        return URLSegmentFilter::create()->filter($cookieName);
    }
}
