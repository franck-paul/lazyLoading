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
declare(strict_types=1);

namespace Dotclear\Plugin\lazyLoading;

use Dotclear\App;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Note;
use Dotclear\Helper\Html\Form\Para;

class BackendBehaviors
{
    /**
     * @param      array<int, array<int, string>>  $ref    The content to filter
     */
    public static function coreContentFilter(string $context, array $ref): string
    {
        $settings = My::settings();

        if ($settings->dimensions) {
            foreach ($ref as $content) {
                if (isset($content[1]) && $content[1] === 'html') {
                    $buffer = &$content[0];
                    if ($buffer !== '') {
                        $buffer = Helper::doImages($buffer);
                    }
                }
            }
        }

        return '';
    }

    public static function adminBlogPreferencesForm(): string
    {
        echo
        (new Fieldset('lazyloading_settings'))
        ->legend((new Legend(__('lazyLoading'))))
        ->fields([
            (new Para())->items([
                (new Checkbox('lazy_loading_enabled', (bool) My::settings()->enabled))
                    ->value(1)
                    ->label((new Label(__('Add the loading="lazy" attribute for images and iframes'), Label::INSIDE_TEXT_AFTER))),
            ]),
            (new Para())->items([
                (new Checkbox('lazy_loading_dimensions', (bool) My::settings()->dimensions))
                    ->value(1)
                    ->label((new Label(__('Add the width and height attributes for images if none present'), Label::INSIDE_TEXT_AFTER))),
            ]),
            (new Note())
                ->class('info')
                ->text(__('Note that these two options are independent')),
        ])
        ->render();

        return '';
    }

    public static function adminBeforeBlogSettingsUpdate(): string
    {
        My::settings()->put('enabled', !empty($_POST['lazy_loading_enabled']), App::blogWorkspace()::NS_BOOL);
        My::settings()->put('dimensions', !empty($_POST['lazy_loading_dimensions']), App::blogWorkspace()::NS_BOOL);

        return '';
    }
}
