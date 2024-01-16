<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File as M_File;
use App\Models\Media;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class FileController extends Controller
{


    private $file;

    public function __construct(FileRepositoryInterface $file)
    {
        $this->file = $file;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function upload(Request $request)
    {
        if ($request->type != "all") {
            $validator = Validator::make($request->file(), [
                'file' => [
                    'required',
                    'mimes:' . $request->mimesFile,
                ]
            ]);
            if ($validator->fails()) {
                dd($validator->errors());
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }
        } else if ($request->type == "all") {

            //

        } else {
            return response()->json([
                'errors' => 'پسوند فایل غیر مجاز است!',
            ], 422);
        }


        $result =  $this->file->upload($request);
        return response()->json([
            'file_id' => $result['id'],
            'path' => $result['path'],
            'thumbnail' => $result['thumbnail'],
        ]);
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
     * Update the specified resource in storage.
     */
    public function remove(Request $request)
    {
        $this->file->destroy($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
