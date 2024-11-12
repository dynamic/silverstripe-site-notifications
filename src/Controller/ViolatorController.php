<?php

namespace Dynamic\Notifications\Controller;

use Dynamic\Notifications\Model\Violator;
use SilverStripe\Control\Controller;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\FieldType\DBHTMLText;

/**
 *
 */
class ViolatorController extends Controller
{
    const URLSEGMENT = 'violatordata'; // phpcs:ignore PSR12.Properties.ConstantVisibility.NotFound

    /**
     * @var string[]
     */
    private static $allowed_actions = [
        'index',
    ];

    /**
     * @return string
     */
    public function getURLSegment()
    {
        return self::URLSEGMENT;
    }

    /**
     * @return DBHTMLText|null
     */
    public function index(): ?DBHTMLText
    {
        $list = Violator::get()->filter([
            'StartTime:LessThanOrEqual' => date("Y-m-d H:i:s", strtotime('now')),
            'EndTime:GreaterThanOrEqual' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        if ($list->count()) {
            return $this->customise([
                'Violators' => $list->sort('Sort'),
            ])->renderWith('ViolatorObjects');
        }

        return null;
    }
}
