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

use DateTime;
use DateTimeZone;
use ErrorException;

require_once dirname(__FILE__) . '/Connection.php';
require_once dirname(__FILE__) . '/ResponseImpl.php';

/**
 * Description of RestSecurityConnection
 *
 * @author luis
 */
class RestSecurityConnection implements Connection {

    private $key;
    private $signature;
    private $body;
    private $formData;
    private $queryParams;
    private $headers;
    private $charset;
    private $targetHost;
    private $targetRelativeURL;
    private $version;
    private $proxyParams;
    private $debug;
    private $formDataEncoded;
    private $contentMd5;
    private $boundary;
    private $allParameters;

    function __construct() {
        $this->clear();
    }

    public function clear() {
        $this->body = '';
        $this->formData = [];
        $this->queryParams = [];
        $this->headers = [];
        $this->charset = Names::UTF8;
        $this->targetHost = '';
        $this->targetRelativeURL = '';
        $this->version = "1.1.4";
        $this->proxyParams = [];
        $this->debug = false;
        $this->contentMd5 = '';
        $this->boundary = '';
        $this->formDataEncoded = '';
        $this->headers[Names::USER_AGENT] = 'RestSecurity-PHP-Consumer/1.0.0';
        $this->allParameters = [];
    }

    function getKey() {
        return $this->key;
    }

    function getSignature() {
        return $this->signature;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function setSignature($signature) {
        $this->signature = $signature;
    }

    public function connect($url) {
        return $this->execute('CONNECT', $url);
    }

    public function delete($url) {
        return $this->execute('DELETE', $url);
    }

    /**
     * @return string[]
     */
    private function createHeaders() {

        $headers = [];

        foreach ($this->headers as $k => $v) {
            $headers[] = $k . ': ' . $v;
        }

        if ($this->debug) {
            echo "\nHEADERS>>>>";
            print_r($headers);
            echo "\n<<<<HEADERS";
        }
        return $headers;
    }

    /**
     * @return string
     */
    public function encodeFormParams() {
        return $this->encodeParams($this->formData);
    }

    /**
     * 
     * @return string
     */
    public function encodeQueryParams() {
        return $this->encodeParams($this->queryParams);
    }

    /**
     * @param array $arr
     * @return string
     */
    public function encodeParams($arr) {
        $enc = "";
        foreach ($arr as $val) {
            if (isset($val["value"]) && $val["value"] != '') {
                $enc = $enc . urlencode($val["name"]) . '=' . urlencode($val["value"]) . '&';
            }
        }

        return $enc;
    }

    /**
     * 
     */
    public function hasQueryParam() {
        return (is_array($this->queryParams) && count($this->queryParams) > 0);
    }

    /**
     * 
     */
    public function hasFormParam() {
        return (is_array($this->formData) && count($this->formData) > 0);
    }

    function generateBoundary() {
        return md5(uniqid(mt_rand(), true));
    }

    private function prepareContentType($method) {
        if ((!isset($this->headers[Names::CONTENT_TYPE]) || $this->headers[Names::CONTENT_TYPE] == '') && $method != 'GET') {
            $this->headers[Names::CONTENT_TYPE] = Names::APPLICATION_X_FORM_URLENCODED;
        }
        if (isset($this->headers[Names::CONTENT_TYPE])) {
            if ($this->headers[Names::CONTENT_TYPE] == Names::APPLICATION_X_FORM_URLENCODED && $this->charset != '') {
                $this->headers[Names::CONTENT_TYPE] = $this->headers[Names::CONTENT_TYPE] . '; charset=' . $this->charset;
            } else if ($this->headers[Names::CONTENT_TYPE] == Names::MULTIPART_FORM_DATA) {
                $this->headers[Names::CONTENT_TYPE] = $this->headers[Names::CONTENT_TYPE] . '; boundary=' . $this->boundary;
            }
        }
    }

    /**
     * Check if header is set, when not, apply the default value.
     * @param string $name
     * @param string $default
     */
    private function checkHeader($name, $default) {
        if (!isset($this->headers[$name])) {
            $this->headers[$name] = $default;
        }
    }

    private function setCurlMethod($ch, $method) {
        switch ($method) {
            case 'GET':
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_PUT, true);
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
        }
    }

    public function execute($method, $url) {
        $this->extractURL($url);
        $this->boundary = $this->generateBoundary();
        $this->prepareContentType($method);
        $this->createSortedParameters();
        $this->generateContentMd5($method);
        $time = $this->getTime();

        $this->headers[Names::AUTHORIZATION] = $this->key . ':' . $this->generateRestSignature($time, $method);
        $this->headers[Names::DATE] = $time;
        $this->headers[Names::VERSION] = $this->version;

        $ch = $this->createCurl($url);
        $this->setCurlMethod($ch, $method);
        $this->setPostFields($ch, $method);
        $this->prepareCurlDebug($ch);
        $this->prepareCurlProxy($ch);

        $response = curl_exec($ch);

        return $this->createResponse($response, $ch);
    }

    private function createResponse($response, $ch) {
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode !== 200) {
            $error = curl_error($ch);
            curl_close($ch);
            return new ResponseImpl($httpcode, $error, "");
        } else {
            curl_close($ch);
            return new ResponseImpl($httpcode, $response);
        }
    }

    private function createCurl($url) {
        $ch = curl_init($url . ($this->hasQueryParam() ? '?' . $this->encodeQueryParams() : ""));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->createHeaders());

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        return $ch;
    }

    private function setPostFields($ch, $method) {
        if ($method == 'POST' && $this->hasFormParam()) {
            if ($this->debug) {
                echo 'USING FORM PARAMS';
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->encodeParams($this->allParameters));
        }
    }

    /**
     * Used by #createSortedParameters
     * @param type $v1
     * @param type $v2
     * @return int
     */
    private function sortParameters($v1, $v2) {
        if ((isset($v1) && !isset($v2)) || (isset($v1["name"]) && !isset($v2["name"]))) {
            return 1;
        } else if ((!isset($v1) && isset($v2)) || (!isset($v1["name"]) && isset($v2["name"]))) {
            return -1;
        }

        return strcmp($v1["name"], $v2["name"]);
    }

    private function createSortedParameters() {
        $this->allParameters = [];
        $this->allParameters = array_merge($this->allParameters, $this->queryParams);
        $this->allParameters = array_merge($this->allParameters, $this->formData);
        usort($this->allParameters, array($this, "sortParameters"));
    }

    private function getSecurityFormData() {

        $desc = "";

        foreach ($this->allParameters as $val) {
            $desc .= $val["name"] . $val["value"];
        }

        return $desc;
    }

    private function generateContentMd5() {
        $this->contentMd5 = '';
        if (isset($this->allParameters) && count($this->allParameters) > 0) {
            $this->contentMd5 = base64_encode(md5($this->getSecurityFormData(), true));
            $this->headers[Names::CONTENT_MD5] = $this->contentMd5;
        }
    }

    private function prepareCurlDebug($ch) {
        if ($this->debug) {
            curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
            $handler = fopen('php://stdout', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $handler);
        }
    }

    private function prepareCurlProxy($ch) {

        $host = isset($this->proxyParams["host"]) ? $this->proxyParams["host"] : '';
        $port = isset($this->proxyParams["port"]) ? $this->proxyParams["port"] : 8080;
        $user = isset($this->proxyParams["user"]) ? $this->proxyParams["user"] : "";
        $passwd = isseT($this->proxyParams["passwd"]) ? $this->proxyParams["passwd"] : "";

        if ($host != '') {
            curl_setopt($ch, CURLOPT_PROXY, $host . ':' . $port);
            if ($user != '') {
                curl_setopt($ch, CURLOPT_PROXYAUTH, $user . ':' . $passwd);
            }

            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        } else {
            curl_setopt($ch, CURLOPT_PROXY, null);
            curl_setopt($ch, CURLOPT_PROXYAUTH, null);
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, false);
        }
    }

    public function setProxyParam($host, $port, $user, $passwd) {
        $this->proxyParams = ["host" => $host, "port" => $port, "user" => $user, "passwd" => $passwd];
    }

    /**
     * @return string
     */
    public function getTime() {
        $datetime = new DateTime();
        $datetime->setTimezone(new DateTimeZone('UTC'));
        return $datetime->format('Y-m-d\TH:i:s\Z');
    }

    private function extractURL($url) {
        $urlInfo = parse_url($url);

        if (!isset($urlInfo['host'])) {
            throw new ErrorException("Invalid URL");
        }

        // Rebuild the string, using remaining pieces.
        $this->targetHost = $urlInfo['host'];
        $this->targetRelativeURL = $urlInfo['path'];
    }

    /**
     * @param type $name
     * @param type $value
     * @return $this
     */
    public function addFormParam($name, $value) {

        if ($name == '' || $value == '') {
            return $this;
        }

        $this->formData[] = ["name" => $name, "value" => $value];

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function clearFormParam($name) {

        if ($name == '') {
            $this->formData = [];
            return $this;
        }

        foreach ($this->formData as $k => $v) {
            if ($v["name"] == $name) {
                unset($this->formData[$k]);
            }
        }

        return $this;
    }

    /**
     * @param type $name
     * @param type $value
     * @return $this
     */
    public function addQueryParam($name, $value) {

        if ($name == '' || $value == '') {
            return $this;
        }

        $this->queryParams[] = ["name" => $name, "value" => $value];

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function clearQueryParam($name) {

        if ($name == '') {
            $this->queryParams = [];
            return $this;
        }

        foreach ($this->queryParams as $k => $v) {
            if ($v["name"] == $name) {
                unset($this->queryParams[$k]);
            }
        }

        return $this;
    }

    /**
     * @param boolean $debug
     * @return $this
     */
    public function setDebug($debug) {
        $this->debug = $debug;
        return $this;
    }

    /**
     * @param type $header
     */
    private function getHeaderValue($header) {
        if (isset($this->headers[$header]) && $this->headers[$header] != '') {
            return $this->headers[$header];
        }
        return "";
    }

    function generateRestSignature($time, $method) {

        $contentType = $this->getHeaderValue(Names::CONTENT_TYPE);
        $contentMd5 = $this->getHeaderValue(Names::CONTENT_MD5);

        $description = $method . "\n";

        if ($contentMd5 != '') {
            $description .= $this->contentMd5 . "\n";
        }

        if ($contentType != '') {
            $description .= $contentType . "\n";
        }

        $description .= $time . "\n" . $this->targetRelativeURL;

        if ($this->debug) {
            echo "\nDEBUGRS>>>>\n" . $description . "\n<<<<DEBUGRS\n";
        }

        return base64_encode(hash_hmac('sha1', $description, $this->signature, true));
    }

    public function get($url) {
        return $this->execute('GET', $url);
    }

    public function head($url) {
        return $this->execute('HEAD', $url);
    }

    public function options($url) {
        return $this->execute('OPTIONS', $url);
    }

    public function path($url) {
        return $this->execute('PATH', $url);
    }

    public function post($url) {
        return $this->execute('POST', $url);
    }

    public function put($url) {
        return $this->execute('PUT', $url);
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    public function setHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setMultiPart($bool) {
        $this->headers[Names::CONTENT_TYPE] = $bool ? Names::MULTIPART_FORM_DATA : Names::APPLICATION_X_FORM_URLENCODED;
        return $this;
    }

    function setCharset($charset) {
        $this->charset = $charset;
        return $this;
    }

}
