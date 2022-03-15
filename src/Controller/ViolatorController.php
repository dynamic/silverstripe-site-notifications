<?php

namespace Dynamic\Notifications\Controller;

use SilverStripe\Control\Controller;
use SilverStripe\Dev\Debug;

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
     * @return mixed
     */
    public function index()
    {
        if ($violators = \Page::get()->first()->getViolators()) {
            return $this->customise([
                'Violators' => $violators,
            ])->renderWith('ViolatorObjects');
        }

        return null;
    }
}
