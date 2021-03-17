<?php
namespace Bitkit\Social;
class Twitter{

    public function __construct($token , $api_version, $link)
    {
        $this->token =  $token;
        $this->version = $api_version;
        $this->domain =  ' https://api.twitter.com';
        $this->link =  $link;
    }


}