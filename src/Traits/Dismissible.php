<?php

namespace Dynamic\Notifications\Traits;

use SilverStripe\Control\Cookie;

/**
 *
 */
trait Dismissible
{
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
        return Cookie::get($this->getCookieName());
    }
}
