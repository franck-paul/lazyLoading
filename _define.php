<?php
/**
 * @brief lazyLoading, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'lazyLoading',
    'Implements lazy loading attribute for images and iframes',
    'Franck Paul',
    '4.0',
    [
        'requires'    => [['core', '2.27'], ['php', '8.1']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_USAGE,
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
        'type'     => 'plugin',
        'settings' => ['blog' => '#params.lazyloading_settings'],

        'details'    => 'https://open-time.net/?q=lazyLoading',
        'support'    => 'https://github.com/franck-paul/lazyLoading',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/lazyLoading/master/dcstore.xml',
    ]
);
