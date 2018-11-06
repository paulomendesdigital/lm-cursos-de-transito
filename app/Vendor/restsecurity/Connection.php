<?php

/*
 * The MIT License
 *
 * Copyright 2018 luis.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace detran\restsecurity;

require_once dirname(__FILE__) . '/Response.php';

/**
 *
 * @author luis
 */
interface Connection {

    /**
     * Clear this connection.
     */
    function clear();

    /**
     * 
     * Override any previous header and set to this value.
     * Note: when $value is empty, the header will be removed.
     * @param type $name
     * @param type $value
     * @return Connection
     */
    function setHeader($name, $value);

    /**
     * Indicate that this request will use multipart/form-data
     * Only used when method is post
     * @param bool $bool
     * @return Connection
     */
    function setMultiPart($bool);

    /**
     * Remove any parameter with the given name.
     * Note: When name is empty, all parameters will be cleared
     * @param string $name
     * @param string $value
     * @return Connection
     */
    function addQueryParam($name, $value);

    /**
     * @param string $name
     * @return Connection
     */
    function clearQueryParam($name);

    /**
     * @param string $name
     * @return Connection
     */
    function addFormParam($name, $value);

    /**
     * Remove any parameter with the given name.
     * Note: When name is empty, all parameters will be cleared
     * @param string $name
     * @return Connection
     */
    function clearFormParam($name);

    /**
     * Replace body with this content.
     * @param string $body
     * @return Connection
     */
    function setBody($body);

    /**
     * 
     * @param string $method HTTP Method
     * @param string $url target url
     * @return Response from server
     */
    function execute($method, $url);

    /**
     * Execute GET request
     * @param string $url
     * @return Response from server
     */
    function get($url);

    /**
     * Execute HEAD request
     * @param string $url
     * @return Response from server
     */
    function head($url);

    /**
     * Execute POST request
     * @param string $url
     * @return Response from server
     */
    function post($url);

    /**
     * Execute PUT request
     * @param string $url
     * @return Response from server
     */
    function put($url);

    /**
     * Execute DELETE request
     * @param string $url
     * @return Response from server
     */
    function delete($url);

    /**
     * Execute CONNECT request
     * @param string $url
     * @return Response from server
     */
    function connect($url);

    /**
     * Execute OPTIONS request
     * @param string $url
     * @return Response from server
     */
    function options($url);

    /**
     * Execute PATH request
     * @param string $url
     * @return Response from server
     */
    function path($url);

    /**
     * 
     * @param string $charset
     * @return Connection
     */
    function setCharset($charset);

    /**
     * Using proxy?
     * @param type $host
     * @param type $port
     * @param type $user
     * @param type $passwd
     */
    function setProxyParam($host, $port, $user, $passwd);

    /**
     * Extra output
     * @param type $debug
     */
    function setDebug($debug);
}
