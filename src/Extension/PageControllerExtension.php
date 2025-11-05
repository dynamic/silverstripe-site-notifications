<?php

namespace Dynamic\Notifications\Extension;

use Dynamic\Notifications\Model\PopUp;
use Dynamic\Notifications\Model\Violator;
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
     * @var bool
     * @config
     * @deprecated 3.0.0 Use template rendering instead of AJAX loading
     */
    private static $use_ajax_violators = false;

    /**
     * @return void
     */
    public function onAfterInit(): void
    {
        // AJAX loading is deprecated but still supported for backwards compatibility
        if ($this->owner->config()->get('use_ajax_violators')) {
            user_error(
                'AJAX violator loading is deprecated and will be removed in version 3.0.0. ' .
                'Set PageController.use_ajax_violators to false and use template rendering instead.',
                E_USER_DEPRECATED
            );
            Requirements::javascript('dynamic/silverstripe-site-notifications: client/js/notifications.js');
        } else {
            // Use template rendering with cookie handling
            Requirements::javascript('dynamic/silverstripe-site-notifications: client/js/violator.js');
        }

        Requirements::javascript('dynamic/silverstripe-site-notifications: client/js/popup.js');
    }

    /**
     * @return PopUp|null
     */
    public function getPopUp(): ?PopUp
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

    /**
     * Get active violators for template rendering
     * 
     * @return ArrayList<Violator>
     */
    public function getViolators(): ArrayList
    {
        $now = date("Y-m-d H:i:s");
        $list = Violator::get();

        $list = $list->filterByCallback(function ($item) use ($now) {
            // Check date range - if dates are set, violator must be within range
            if ($item->StartTime && $item->StartTime >= $now) {
                return false;
            }
            if ($item->EndTime && $item->EndTime <= $now) {
                return false;
            }

            // Check ShowOnce cookie
            if ($item->ShowOnce && Cookie::get($item->CookieName)) {
                return false;
            }

            return true;
        });

        return $list->sort('Sort');
    }
}
