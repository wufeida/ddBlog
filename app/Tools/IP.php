<?php

namespace App\Tools;

use Illuminate\Http\Request;

class IP
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * IP constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the client ip.
     *
     * @return mixed|string
     */
    public function get()
    {
        $ip = $this->request->getClientIp();

        if($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }

    public function getSite($ip = ''){
        if(empty($ip)){
            $ip = $this->get();
        }
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        if(empty($res)){ return false; }
        $jsonMatches = array();
        preg_match('#\{.+?\}#', $res, $jsonMatches);
        if(!isset($jsonMatches[0])){ return false; }
        $json = json_decode($jsonMatches[0], true);
        if(isset($json['ret']) && $json['ret'] == 1){
            $json['ip'] = $ip;
            unset($json['ret']);
        }else{
            return false;
        }
        return $json;
    }
}
