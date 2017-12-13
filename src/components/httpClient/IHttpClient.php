<?php

namespace endurant\braintreedonation\components\httpClient;

interface IHttpClient
{
    public function get($url);
    public function post($url, $body=null);
}
