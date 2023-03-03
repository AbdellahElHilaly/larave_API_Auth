<?php

namespace App\Traits\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use DeviceDetector\Parser\Browser\BrowserParserAbstract;
use DeviceDetector\Parser\OperatingSystem\OperatingSystemParserAbstract;
use Illuminate\Support\Str;
// use GuzzleHttp\Client;

trait Helper
{

    public function generateToken()
    {
        $dd = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);
        $dd->parse();
        $device = $dd->getDeviceName();
        $platform = $dd->getOs('name');
        $browser = $dd->getClient('name');
        $ip = request()->ip();
        $key = 'at_ssHlScfmx4QhQEJZVnVwIrLqwgivl';
        $time = time();
        $expiresAt = strtotime('+1 day', $time); // Token will expire in 1 day

        $client = new Client();
        $url = 'https://geo.ipify.org/api/v2/country,city,vpn?apiKey='.$key.'&ipAddress='.$ip;
        $response = $client->get($url);
        $ipInformations = json_decode($response->getBody(), true);


        if(isset($ipInformations['location'])){
            $location = [
                "country" => $ipInformations['location']['country'],
                "region" => $ipInformations['location']['region'],
                "city" => $ipInformations['location']['city'],
            ];
        }else $location = "no data";

        if(isset($ipInformations['as']))
            $network = [
                "name" => $ipInformations['as']['name'],
                "route" => $ipInformations['as']['route'],
                "domain" => $ipInformations['as']['domain'],
            ];
            else $network = "no data";


        $token = [
            'ip' => $ip,
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
            'expires_at' => $expiresAt,
            'secret' => rand(100000000, 999999999),
            'location' => $location,
            'network' => $network,
        ];

        return $token;
    }


}
