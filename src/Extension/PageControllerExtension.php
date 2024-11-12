<?php

namespace Dynamic\Notifications\Extension;

use Dynamic\Notifications\Model\PopUp;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DB;
use SilverStripe\View\Requirements;

/**
 *
 */
class PageControllerExtension extends Extension
{
    /**
     * @return void
     */
    public function onAfterInit(): void
    {
        Requirements::javascript('dynamic/silverstripe-site-notifications: client/js/notifications.js');
        Requirements::javascript('dynamic/silverstripe-site-notifications: client/js/popup.js');
    }

    /**
     * @return DataList
     */
    public function getPopUps(): DataList
    {
        $list = PopUp::get()->filter([
            'StartTime:LessThanOrEqual' => date("Y-m-d H:i:s", strtotime('now')),
            'EndTime:GreaterThanOrEqual' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        return $list->shuffle();
    }
}
