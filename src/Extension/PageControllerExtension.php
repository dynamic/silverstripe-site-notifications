<?php

namespace Dynamic\Notifications\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;

/**
 *
 */
class PageControllerExtension extends Extension
{
    /**
     * @return void
     */
    public function onAfterInit()
    {
        Requirements::javascript('dynamic/silverstripe-site-notifications: client/js/notifications.js');
    }
}
