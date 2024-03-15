<?php

namespace App\Http\Controllers;

use App\Models\BrowserClicks;
use App\Models\IpClicks;
use App\Models\ShortUrl;
// use DeviceDetector\Parser\Client\Browser;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    function index($short_url)
    {

        if (ShortUrl::where("short_url", $short_url)->exists()) {
            $short_url = ShortUrl::where("short_url", $short_url)->first();
            $short_url->clicks = $short_url->clicks + 1;
            $short_url->save();

            $this->countBrowserClicks($short_url);
            $this->countIpClicks($short_url);


            return redirect()->to($short_url->original_url);
        } else {
            abort(404);
        }
    }

    function countBrowserClicks($short_url)
    {
        $agent = new Agent();

        $browser_short_url = BrowserClicks::where('short_url_id', $short_url->id)->where('browser', $agent->browser())->first();
        if (empty($browser_short_url)) {
            $browser_short_url = new BrowserClicks();
            $browser_short_url->short_url_id = $short_url->id;
            $browser_short_url->browser = $agent->browser();
            $browser_short_url->clicks = 1;
            $browser_short_url->save();
        } else {

            $browser_short_url->clicks = $browser_short_url->clicks + 1;
            $browser_short_url->save();
        }
    }

    function countIpClicks($short_url)
    {
        $ip_short_url = IpClicks::where('short_url_id', $short_url->id)->where('ip_address', request()->ip())->first();
        if (empty($ip_short_url)) {
            $ip_short_url = new IpClicks();
            $ip_short_url->short_url_id = $short_url->id;
            $ip_short_url->ip_address = request()->ip();
            $ip_short_url->clicks = 1;
            $ip_short_url->save();
        } else {

            $ip_short_url->clicks = $ip_short_url->clicks + 1;
            $ip_short_url->save();
        }
    }
}
