<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

use App\Repositories\Admin\ExperienceRepository;
use App\Repositories\Admin\ShortnerRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;


class ShortnerController extends Controller
{
    private $repository;

    function __construct(ShortnerRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->ajax()) {
            return DataTables::of($this->repository->all())


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

        $data['page'] = "Shortner";
        $data['title'] = "Shortner";
        $data['pageTitle'] = "Shortner";

        return  view('admin.shortner.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data['title'] = 'Create Short Link';
        return  view('admin.shortner.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([

            'original_url' => 'required|url',


        ]);
        return  $this->repository->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {

        $data['title'] = $experience->name;
        $data['experience'] = $experience;


        return view('admin.shortner.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {

        $data['title'] = 'Edit Experience';
        $data['experience'] = $experience;


        return view('admin.shortner.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {

        $request->validate([

            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required|date',
            'is_present' => 'required',

        ]);
        return  $this->repository->update($experience);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {

        return  $this->repository->delete($experience);
    }
}
