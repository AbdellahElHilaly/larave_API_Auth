<?php

namespace App\Traits\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use DeviceDetector\Parser\Browser\BrowserParserAbstract;
use DeviceDetector\Parser\OperatingSystem\OperatingSystemParserAbstract;
use Illuminate\Support\Str;

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
        $time = time();
        $expiresAt = strtotime('+1 day', $time); // Token will expire in 1 day
        $isWifi = false;

        // Check if connection is WiFi
        if (isset($_SERVER['HTTP_USER_AGENT']) && isset($_SERVER['HTTP_CONNECTION'])) {
            if (stripos($_SERVER['HTTP_USER_AGENT'], 'android') !== false && stripos($_SERVER['HTTP_USER_AGENT'], 'mobile') !== false) {
                if (stripos($_SERVER['HTTP_CONNECTION'], 'wifi') !== false) {
                    $isWifi = true;
                }
            }
        }

        $client = new Client();
        $response = $client->get("https://ipapi.co/$ip/json/");
        $location = json_decode($response->getBody(), true);

        $token = [
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
            'ip' => $ip,
            'time' => $time,
            'expires_at' => $expiresAt,
            'is_wifi' => $isWifi,
            'secret' => Str::random(60),
            'location' => $location,
        ];

        return $token;
    }

}
