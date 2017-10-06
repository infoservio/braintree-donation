<?php

namespace endurant\donationsfree\components\httpClient;

// use GuzzleHttp\Client;

class HttpClient extends Component implements IHttpClient
{
    private $http;
    
    public function init()
    {
        // $this->http = new Client();
    }
    
    public function get($url) {
        $res = $this->http->request('GET', $url);
        return $res->getStatusCode();
    }
    
    public function post($url, $body=null) {
        $res = $this->http->request('POST', $url, $body);
        return $res->getStatusCode();
        
    }
}
