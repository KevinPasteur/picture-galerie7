<?php

namespace App\Http\Controllers;

use App\Picture;
use Illuminate\Http\Request;
use App\Http\Requests\PictureRequest;
use Str;
use Storage;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pictures = Picture::all();
        return view('pictures.index', compact('pictures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => ['key' => env('AWS_ACCESS_KEY_ID'), 'secret' => env('AWS_SECRET_ACCESS_KEY')],
        ]);
        $bucket = env('AWS_BUCKET');
        $key = "pictures/". Str::random(5);

        $formInputs = ['acl' => 'private', 'key' => $key];
        $options = [
            ['acl' => 'private'],
            ['bucket' => $bucket],
            ['eq','$key', $key],
        ];
        $expires = '+1 hours';
        $postObject = new \Aws\S3\PostObjectV4(
            $client,
            $bucket,
            $formInputs,
            $options,
            $expires
        );
        $formAttributes = $postObject->getFormAttributes();
        $formInputs = $postObject->getFormInputs();

        return view('pictures.create', ['s3attributes' => $formAttributes,
                                        's3inputes' => $formInputs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PictureRequest $request)
    {
        $picture = new Picture();
        $picture->fill($request->all());
        $picture->save();
        
        return redirect('pictures')->with('status', 'IMG bien ajouter');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Picture $picture)
    {
        if (Str::startsWith($request->header('Accept'),'image'))
        {
            return redirect(Storage::disk('s3')->temporaryUrl($picture->storage_path, now()->addMinute(1)));
        }

        return view('pictures.show', compact('picture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        //dd($picture->storage_path);
        $picture->delete();
        Storage::disk('s3')->delete($picture->storage_path);
        $a= redirect('pictures')->with('status', 'IMG bien supprimée');
        dd($a);
    }
}
