<?php

/**
 * kuyoto getallheaders (https://github.com/kuyoto/getallheaders/)
 *
 * PHP version 5 and 7
 *
 * @category  Library
 * @package   kuyoto\getallheaders
 * @author    Tolulope Kuyoro <nifskid1999@gmail.com>
 * @copyright 2020 Tolulope Kuyoro <nifskid1999@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php (MIT License)
 * @version   GIT: master
 * @link      https://github.com/kuyoto/getallheaders/
 */

declare(strict_types=1);

if (! function_exists('getallheaders')) {

    /**
     * Returns all HTTP headers from the current request.
     *
     * @link http://www.php.net/manual/en/function.getallheaders.php
     *
     * @return array The HTTP header key/value pairs.
     */
    function getallheaders()
    {
        $headers = [];
        $server  = &$_SERVER;

        foreach ($server as $key => $value) {
            // Apache prefixes environment variables with REDIRECT_
            // if they are added by rewrite rules
            if (strpos($key, 'REDIRECT_') === 0) {
                $key = substr($key, 9);

                // We will not overwrite existing variables with the
                // prefixed versions, though
                if (array_key_exists($key, $server)) {
                    continue;
                }
            }

            if ($value === '') {
                continue;
            }

            if (strpos($key, 'HTTP_') === 0) {
                $name           = str_replace(
                    ' ',
                    '-',
                    ucwords(strtolower(str_replace('_', ' ', substr($key, 5))))
                );
                $headers[$name] = $value;
                continue;
            }

            if (strpos($key, 'CONTENT_') === 0) {
                $name           = sprintf(
                    'Content-%s',
                    ucwords(strtolower(str_replace('_', ' ', substr($key, 8))))
                );
                $headers[$name] = $value;
                continue;
            }
        }

        return $headers;
    }

}
