<?php
namespace Bitkit\Social;
class Facebook {

    public function __construct($token , $api_version, $link)
    {
        $this->token =  $token;
        $this->version = 'v'.$api_version;
        $this->domain =  'https://graph.facebook.com';
        $this->link =  $link;
    }
}