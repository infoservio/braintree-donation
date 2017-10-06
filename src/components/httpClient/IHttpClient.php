<?php

namespace endurant\donationsfree\components\httpClient;

interface IHttpClient
{
    public function get($url);
    public function post($url, $body=null);
}
