<?php

namespace endurant\donationsfree\components\httpClient;

// use GuzzleHttp\Client;

class HttpClient extends Component implements IHttpClient
{
    private $_http;
    
    public function init()
    {
        // $this->_http = new Client();
    }
    
    public function get($url) {
        $res = $this->_http->request('GET', $url);
        return $res->getStatusCode();
    }
    
    public function post($url, $body=null) {
        $res = $this->_http->request('POST', $url, $body);
        return $res->getStatusCode();
        
    }
}
