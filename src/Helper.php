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
declare(strict_types=1);

namespace Dotclear\Plugin\lazyLoading;

use Dotclear\App;
use Dotclear\Helper\File\File;

/**
 * Code inspired by Julien Mudry from imgWidthAndHeightAdder dotclear 2 plugin (GPL-2.0 licence)
 */
class Helper
{
    /**
     * @var array<string, array{w: int<0, max>, h: int<0, max>}>
     */
    protected static array $images = [];

    public static function doImages(string $buffer): string
    {
        $pattern = '#(?:<img[^>]+src="(.+?)".*?>)#msu';

        if ($buffer !== '') {
            // Find every image
            if (preg_match_all($pattern, $buffer, $match) > 0) {
                foreach ($match[1] as $src) {
                    self::$images[$src] = [
                        'w' => 0,
                        'h' => 0,
                    ];
                }

                // Lookup the size for each image found
                self::getMediaItems();

                // Add size information to every img tag
                $buffer = preg_replace_callback($pattern, self::photoSize(...), $buffer);
            }
        }

        return $buffer ?? '';
    }

    /**
     * Gets the media items.
     */
    protected static function getMediaItems(): void
    {
        $paths    = array_keys(self::$images);
        $root     = App::media()->getRoot();
        $root_url = App::media()->getRootUrl();
        $p_url    = is_string($p_url = App::blog()->settings()->system->public_url) ? $p_url : '';

        foreach ($paths as $v) {
            // Extract the file name for the image
            $file_name = preg_replace('/^' . preg_quote($p_url, '/') . '(\/?)/', '', $v);

            // Workaround for a bug with Dotclear 2.36: first make sure the file exists
            if (file_exists($root . '/' . $file_name)) {
                // Find the file system path to the image
                $f = new File($root . '/' . $file_name, $root, $root_url);

                if ($f->file !== '') {
                    // Query the image sizes
                    $media_info = getimagesize($f->file);
                    if ($media_info !== false) {
                        self::$images[$v]['w'] = $media_info[0];
                        self::$images[$v]['h'] = $media_info[1];
                    }
                } else {
                    App::error()->add(__('Unable to find the image file and extract its dimensions for ') . $v);
                }
            } else {
                App::error()->add(__('Unable to find the image file and extract its dimensions for ') . $v);
            }
        }
    }

    /**
     * @param      array<string>         $match  The match
     *
     * @return     string
     */
    protected static function photoSize(array $match): string
    {
        if (str_contains($match[0], 'width=') || str_contains($match[0], 'height=')) {
            // One or both dimensions are already here, don't add anything more
            return $match[0];
        }

        $img = self::$images[$match[1]];
        if ($img['w'] === 0 || $img['h'] === 0) {
            return $match[0];
        }

        return (string) preg_replace('#(<img[^>]+src="[^"]+?".*?)/?>#msu', '$1 width="' . $img['w'] . '" height="' . $img['h'] . '">', $match[0]);
    }
}
