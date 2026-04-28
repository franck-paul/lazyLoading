<?php

/**
 * @brief lazyLoading, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'lazyLoading',
    'Implements lazy loading attribute for images and iframes',
    'Franck Paul',
    '7.0.1',
    [
        'date'        => '2026-04-06T14:48:40+0200',
        'requires'    => [['core', '2.36']],
        'permissions' => 'My',
        'type'        => 'plugin',
        'settings'    => ['blog' => '#params.lazyloading_settings'],

        'details'    => 'https://open-time.net/?q=lazyLoading',
        'support'    => 'https://github.com/franck-paul/lazyLoading',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/lazyLoading/main/dcstore.xml',
        'license'    => 'gpl2',
    ]
);
