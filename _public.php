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
if (!defined('DC_RC_PATH')) {
    return;
}

class lazyLoadingPublicBehaviors
{
    public static function publicAfterContentFilter($tag, $args)
    {
        dcCore::app()->blog->settings->addNameSpace('lazyLoading');
        if (!dcCore::app()->blog->settings->lazyLoading->enabled) {
            return;
        }

        // If only on Entry/Comment content uncomment next line
        if (!in_array($tag, ['EntryContent', 'EntryExcerpt', 'CommentContent'])) {
            return;
        }

        // Look for img or iframe in content ($args[0])
        // Code adapted from WP Lazy Loading plugin (see https://github.com/WordPress/wp-lazy-loading)
        $args[0] = preg_replace_callback('/<(img|iframe)\s[^>]+/', function ($matches) {
            // Look if a loading attribute is already here or not
            if (!preg_match('/\sloading\s*=/', $matches[0])) {
                $buffer = ' loading="lazy"';
                // Look if no alt attribute is present or if it is empty
                if (!preg_match('/\salt="([^"]+?)"\s*/', $matches[0])) {
                    // Look if a decoding attribute is already here or not
                    if (!preg_match('/\sdecoding\s*=/', $matches[0])) {
                        // Decoding attribute not found, add one
                        $buffer .= ' decoding="async"';
                    }
                }
                // Loading attribute not found, add one
                return str_replace('<' . $matches[1], '<' . $matches[1] . $buffer, $matches[0]);
            }
        }, $args[0]);
    }
}

dcCore::app()->addBehavior('publicAfterContentFilterV2', [lazyLoadingPublicBehaviors::class, 'publicAfterContentFilter']);
