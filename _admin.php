<?php
/**
 * @brief lazyLoading, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('DC_CONTEXT_ADMIN')) {return;}

// dead but useful code, in order to have translations
__('lazyLoading') . __('Implements lazy loading attribute for images and iframes');

$core->addBehavior('adminBlogPreferencesForm', ['lazyLoadingAdminBehaviors', 'adminBlogPreferencesForm']);
$core->addBehavior('adminBeforeBlogSettingsUpdate', ['lazyLoadingAdminBehaviors', 'adminBeforeBlogSettingsUpdate']);

class lazyLoadingAdminBehaviors
{
    public static function adminBlogPreferencesForm($core, $settings)
    {
        $settings->addNameSpace('lazyLoading');
        echo
        '<div class="fieldset" id="lazy_loading"><h4>' . __('lazyLoading') . '</h4>' .
        '<p><label class="classic">' .
        form::checkbox('lazy_loading_enabled', '1', $settings->lazyLoading->enabled) .
        __('Enable lazy loading implementation') . '</label></p>' .
            '</div>';
    }

    public static function adminBeforeBlogSettingsUpdate($settings)
    {
        $settings->addNameSpace('lazyLoading');
        $settings->lazyLoading->put('enabled', !empty($_POST['lazy_loading_enabled']), 'boolean');
    }
}

