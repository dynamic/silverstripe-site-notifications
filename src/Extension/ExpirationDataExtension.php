<?php

namespace Dynamic\Notifications\Extension;

use SilverStripe\Core\Extension\Extension;

class ExpirationDataExtension extends Extension
{
    /**
     * @var array
     */
    private static $db = [
        'StartTime' => 'DBDatetime',
        'EndTime' => 'DBDatetime',
    ];

    /**
     * @var array
     */
    private static $casting = [
        'IsActive' => 'Boolean',
    ];

    /**
     * @return bool
     */
    public function getIsActive()
    {
        $date = date('Y-m-d H:i:s', strtotime('now'));
        return $this->owner->StartTime <= $date && $this->owner->EndTime >= $date;
    }
}
