<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrowserClicks;
use App\Models\IpClicks;
use App\Models\Resume;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AdminDashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(ShortUrl::where('user_id', auth()->user()->id)->limit(5)->get())


                ->addColumn('action', function ($row) {
                    $action = '';


                    $action = $action .  '<button data-href="' . action('App\Http\Controllers\Admin\ShortnerController@destroy', [$row->id]) . '" class="btn btn-sm btn-danger delete_button" ><i class="glyphicon glyphicon-trash"></i>' . __("Delete") . '</button>';
                    return $action;
                })
                ->editColumn('original_url', function ($row) {
                    return '<input id="org_' . $row->id . '" value="' . $row->original_url . '" type="hidden">' . Str::limit($row->original_url, 10) . '</input><button class="btn btn-primary" onclick=copyToClipboard("org_' . $row->id . '")><i class="fa fa-copy" title="Copy URL"></i></button>';
                })
                ->editColumn('short_url', function ($row) {
                    return '<input id="short_' . $row->id . '" value="' . url("/") . "/" . $row->short_url . '" type="hidden">' . url("/") . "/" . $row->short_url . '</input><button class="btn btn-primary" onclick=copyToClipboard("short_' . $row->id . '")><i class="fa fa-copy" title="Copy Short URL"></i></button>';
                })
                ->rawColumns(['action', 'original_url', 'short_url'])
                ->make(true);
        }
        $browser_clicks = BrowserClicks::leftJoin('short_urls', 'short_urls.id', '=', 'browser_clicks.short_url_id')->groupBy('browser_clicks.browser')->select('browser_clicks.browser as x', DB::raw('Sum(browser_clicks.clicks) as y'))->get();
        $data['browser_clicks'] = $browser_clicks;

        $data['ip_clicks'] = IpClicks::leftJoin('short_urls', 'short_urls.id', '=', 'ip_clicks.short_url_id')->groupBy('ip_clicks.ip_address')->select('ip_clicks.ip_address as x', DB::raw('SUM(ip_clicks.clicks) as y'))->get();


        $data['page'] = "Dashboard";
        return view('admin.dashboard.dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
