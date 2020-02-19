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

if (!defined('DC_RC_PATH')) {return;}

$this->registerModule(
    "lazyLoading",                                              // Name
    "Implements lazy loading attribute for images and iframes", // Description
    "Franck Paul",                                              // Author
    '1.0',                                                      // Version
    [
        'requires'    => [['core', '2.15']],
        'permissions' => 'usage,contentadmin',                         // Permissions
        'type'        => 'plugin',                                     // Type
        'support'     => 'https://github.com/franck-paul/lazyLoading', // Support URL
        'settings'    => ['blog' => '#params.lazy_loading']           // Settings
    ]
);
