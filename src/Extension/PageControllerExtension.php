<?php

namespace Dynamic\Notifications\Extension;

use Dynamic\Notifications\Model\PopUp;
use SilverStripe\Control\Cookie;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
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
     * @return PopUp
     */
    public function getPopUp(): PopUp
    {
        $list = PopUp::get()->filter([
            'StartTime:LessThanOrEqual' => date("Y-m-d H:i:s", strtotime('now')),
            'EndTime:GreaterThanOrEqual' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $list = $list->filterByCallback(function ($item) {
            if ($item->ShowOnce) {
                if (Cookie::get($item->CookieName)) {
                    return false;
                }
            }

            return true;
        });

        return $list->shuffle()->first();
    }
}
