<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Blog::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        // validate blog form request

        $validation = $request->validate([
            'title'=>'required|unique:blogs|max:355',
            'description' => 'required | max:1055',
            'thumbnail' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tag' =>'required',
            'category' => 'required'
        ]);

        //naming and storing image
        if($validation){
            if($request->hasFile("thumbnail")){
        $ext = $request->thumbnail->getClientOriginalExtension();
        $blog_thumbnail = time().'.'.$ext;
        $request->thumbnail->move(public_path() . '/blog_thumbnails/', $blog_thumbnail);
            }
        }
        // saving fields:

        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $blog_thumbnail,
            'tag' => $request->tag,
            'category' => $request->category,
        ]);

        // returning response

        return response([
            'message'=>'Blog successfully Posted',
            'status'=>true
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Blog::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Blog::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $blog = Blog::find($id);

         // validate blog form request

         $validation = $request->validate([
            'title'=>'required|max:255',
            'description' => 'required',
            'thumbnail' =>'|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tag' =>'required',
            'category' => 'required'
        ]);

        

        //naming and storing image
        $oldThumbnail = $request->thumbnail;
        if($validation){
            if($request->hasFile("thumbnail")){
        $ext = $request->thumbnail->getClientOriginalExtension();
        $blog_thumbnail = time().'.'.$ext;
        $request->thumbnail->move(public_path() . '/blog_thumbnails/', $blog_thumbnail);
            }
        }
        // saving the updated post

        $blog->update([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $blog_thumbnail,
            'tag' => $request->tag,
            'category' => $request->category,
        ]);

        // deleting the old thumbnail:

        File::delete(public_path() . '/blog_thumbnails/'.$oldThumbnail);
        

        // returning response

        return response([
            'message'=>'Blog successfully Updated',
            'status'=>true
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        File::delete(public_path() . '/blog_thumbnails/'.$blog->thumbnail);
        $blog->delete();

        // retrun response
        return response([
            'message'=>'Data successfully Deleted',
            'status'=>true
        ]);

    }
}
