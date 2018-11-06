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
 * Description of ResponseImpl
 *
 * @author luis
 */
class ResponseImpl implements Response {

    private $httpCode;
    private $body;

//    private $headers;

    function __construct($httpCode, $body
//            ,$headers
    ) {
        $this->httpCode = $httpCode;
        $this->body = $body;
//        $this->headers = $headers;
    }

    public function getBody() {
        return $this->body;
    }

    public function getHttpCode() {
        return $this->httpCode;
    }

//
//    public function getResponseHeaders() {
//        return $this->headers;
//    }
}
