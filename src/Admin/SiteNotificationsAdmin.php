<?php

namespace Dynamic\Notifications\Admin;

use Dynamic\Notifications\Model\PopUp;
use Dynamic\Notifications\Model\Violator;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class SiteNotificationsAdmin
 * @package Dynamic\Notifications\Admin
 */
class SiteNotificationsAdmin extends ModelAdmin
{
    /**
     * @var string
     */
    private static string $url_segment = 'notificatiopns-admin';

    /**
     * @var string
     */
    private static string $menu_title = 'Site Notifications';

    /**
     * @var string
     */
    private static string $menu_icon_class = 'font-icon-attention';

    /**
     * @var array
     */
    private static array $managed_models = [
        Violator::class,
        PopUp::class,
    ];

    /**
     * @param $id
     * @param $fields
     * @return Form
     */
    public function getEditForm($id = null, $fields = null): Form
    {
        $form = parent::getEditForm($id, $fields);
        //This check is simply to ensure you are on the managed model you want to adjust accordingly
        if (
            $this->modelClass == Violator::class &&
            $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))
        ) {
            //This is just a precaution to ensure we got a GridField from dataFieldByName() which you should have
            if ($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
            }
        }
        return $form;
    }
}
