<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = $this->getTagNames(Image::with('tags')->get());

        return view('welcome', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'file' => 'image'
        ]);

        $path = $request->file('file')->store('/', 'public');


        $image = Image::create([
            'photo' => 'storage/' . $path
        ]);
 
        return [
            'status' => 'success',
            'image' => $image->load('tags')
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $image->syncTags($request->tags);

        return [
            'status' => 'success'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter(Request $request)
    {
        $images = $this->getTagNames(Image::with('tags')->withAllTags($request->filters)->get());

        return [
            'status' => 'success',
            'images' => $images
        ];
    }

    protected function getTagNames($images)
    {
        return array_map(function($i) {
            $i['tags'] = array_pluck($i['tags'], 'name.en');
            return $i;
        }, $images->toArray());
    }
}
