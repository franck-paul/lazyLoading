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
use Dotclear\Core\Content;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Note;
use Dotclear\Helper\Html\Form\Para;

class BackendBehaviors
{
    /**
     * @param      Content[]  $contents    The content to filter
     */
    public static function coreContentFilter(string $context, array $contents): string
    {
        $settings = My::settings();

        if ($settings->getBool('dimensions')) {
            foreach ($contents as $content) {
                if ($content->getFormat() === 'html') {
                    $buffer = $content->getContent();
                    if ($buffer !== '') {
                        $buffer = Helper::doImages($buffer);
                        $content->setContent($buffer);
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
                (new Checkbox('lazy_loading_enabled', My::settings()->getBool('enabled', false)))
                    ->value(1)
                    ->label((new Label(__('Add the loading="lazy" attribute for images and iframes'), Label::INSIDE_TEXT_AFTER))),
            ]),
            (new Para())->items([
                (new Checkbox('lazy_loading_dimensions', My::settings()->getBool('dimensions', false)))
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
