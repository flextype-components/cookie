<?php

/**
 * @package Flextype Components
 *
 * @author Sergey Romanenko <awilum@yandex.ru>
 * @link http://components.flextype.org
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flextype\Component\Cookie;

class Cookie
{

    /**
     * Set a cookie
     *
     * Cookie::set('username', 'Awilum');
     *
     * @param  string  $key      A name for the cookie.
     * @param  mixed   $value    The value to be stored. Keep in mind that they will be serialized.
     * @param  int     $expire   The number of seconds that this cookie will be available.
     * @param  string  $path     The path on the server in which the cookie will be availabe. Use / for the entire domain, /foo if you just want it to be available in /foo.
     * @param  string  $domain   The domain that the cookie is available on. Use .example.com to make it available on all subdomains of example.com.
     * @param  bool $secure   Should the cookie be transmitted over a HTTPS-connection? If true, make sure you use a secure connection, otherwise the cookie won't be set.
     * @param  bool $httpOnly Should the cookie only be available through HTTP-protocol? If true, the cookie can't be accessed by Javascript, ...
     * @return bool
     */
    public static function set(string $key, $value, int $expire = 86400, string $domain = '', string $path = '/', bool $secure = false, bool $httpOnly = false) : bool
    {
        // Redefine vars
        $value    = serialize($value);
        $expire   = time() + $expire;

        // Set cookie
        return setcookie($key, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

    /**
     * Get a cookie
     *
     * $username = Cookie::get('username');
     *
     * @param  string $key The name of the cookie that should be retrieved.
     * @return mixed
     */
    public static function get(string $key)
    {
        // Redefine key
        $key = (string) $key;

        // Cookie doesn't exist
        if (! isset($_COOKIE[$key])) {
            return false;
        }

        // Fetch base value
        $value = (get_magic_quotes_gpc()) ? stripslashes($_COOKIE[$key]) : $_COOKIE[$key];

        // Unserialize
        $actual_value = @unserialize($value);

        // If unserialize failed
        if ($actual_value === false && serialize(false) != $value) {
            return false;
        }

        // Everything is fine
        return $actual_value;
    }


    /**
     * Delete a cookie
     *
     * Cookie::delete('username');
     *
     * @param string $name The name of the cookie that should be deleted.
     */
    public static function delete(string $key) : void
    {
        unset($_COOKIE[$key]);
    }
}
