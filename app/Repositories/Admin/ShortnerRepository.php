<?php

namespace App\Repositories\Admin;

use App\Models\Experience;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ShortnerRepository
{

    function all(): Object
    {
        return ShortUrl::where('user_id', auth()->user()->id)->get();
    }


    public function store()
    {
        try {

            if (ShortUrl::where('original_url', request()->original_url)->where('user_id', auth()->user()->id)->exists()) {
                return  [
                    'success' => true,
                    'path' => '/shortner',
                    'msg' => "Short Link Generated Successfully"
                ];
            }
            $input = request()->only([
                'original_url'
            ]);
            $short_link = Str::random(6);

            while (ShortUrl::where('short_url', $short_link)->exists()) {
                $short_link = Str::random(6);
            }
            $input['short_url'] = $short_link;
            $input['user_id'] = auth()->user()->id;
            ShortUrl::create($input);

            if (request()->ajax()) {
                $output =  [
                    'success' => true,
                    'path' => '/shortner',
                    'msg' => "Short Link Generated Successfully"
                ];
            } else {
                $output = redirect()->back();
            }
        } catch (\Exception $e) {


            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => "Something went Wrong"
            ];
        }
        return $output;
    }

    public function delete(Experience $experience)
    {

        try {


            $experience->delete();

            $output = [
                'success' => true,
                'msg' => "Short Link Deleted Successfully"
            ];
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => 'Something went Wrong'
            ];
        }
        return $output;
    }
}
