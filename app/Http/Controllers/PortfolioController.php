<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use Illuminate\Support\Facades\File;
class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Portfolio::all();
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
      // validate Portfolio form request

      $validation = $request->validate([
        'title'=>'required|unique:portfolios|max:355',
        'description' => 'required | max:1055',
        'thumbnail' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'full_thumbnail' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        'github_link' =>'required',
        'code_link' => 'required',
        'view_link' => 'required',
    ]);

    //naming and storing image
    if($validation){
        if($request->hasFile("thumbnail")){
            $ext = $request->thumbnail->getClientOriginalExtension();
            $portfolio_thumbnail = time().'.'.$ext;
            $request->thumbnail->move(public_path() . '/portfolio_thumbnails/', $portfolio_thumbnail);
        }
        if($request->hasFile("full_thumbnail")){
            $ext = $request->full_thumbnail->getClientOriginalExtension();
            $portfolio_full_thumbnail = time().'full_thumb'.'.'.$ext;
            $request->full_thumbnail->move(public_path() . '/portfolio_thumbnails/', $portfolio_full_thumbnail);
        }
    }
    // saving fields:

    $portfolio = Portfolio::create([
        'title' => $request->title,
        'description' => $request->description,
        'thumbnail' => $portfolio_thumbnail,
        'full_thumbnail' => $portfolio_full_thumbnail,
        'github_link' =>$request->github_link,
        'code_link' => $request->code_link,
        'view_link' => $request->view_link,
    ]);

    // returning response

    return response([
        'message'=>'Portfolio successfully Posted',
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
    return Portfolio::find($id);
}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function edit($id)
{
    return Portfolio::find($id);
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
    
    $Portfolio = Portfolio::find($id);

     // validate Portfolio form request

     $validation = $request->validate([
        'title'=>'required|max:255',
        'description' => 'required',
        'thumbnail' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'full_thumbnail' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        'github_link' =>'required',
        'code_link' => 'required',
        'view_link' => 'required',
    ]);

    

    //naming and storing image
    $oldThumbnail = $request->thumbnail;
    if($validation){
        if($request->hasFile("thumbnail")){
            $ext = $request->thumbnail->getClientOriginalExtension();
            $Portfolio_thumbnail = time().'.'.$ext;
            $request->thumbnail->move(public_path() . '/Portfolio_thumbnails/', $Portfolio_thumbnail);
        }
        if($request->hasFile("full_thumbnail")){
            $ext = $request->full_thumbnail->getClientOriginalExtension();
            $portfolio_full_thumbnail = time().'full_thumb'.'.'.$ext;
            $request->full_thumbnail->move(public_path() . '/portfolio_thumbnails/', $portfolio_full_thumbnail);
        }
    }
    // saving the updated post

    $Portfolio->update([
        'title' => $request->title,
        'description' => $request->description,
        'thumbnail' => $Portfolio_thumbnail,
        'full_thumbnail' => $Portfolio_full_thumbnail,
        'github_link' =>$request->github_link,
        'code_link' => $request->code_link,
        'view_link' => $request->view_link,
    ]);

    // deleting the old thumbnail:

    File::delete(public_path() . '/portfolio_thumbnails/'.$oldThumbnail);
    

    // returning response

    return response([
        'message'=>'Portfolio successfully Updated',
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
    $portfolio = Portfolio::find($id);
    File::delete(public_path() . '/portfolio_thumbnails/'.$portfolio->thumbnail);
    $portfolio->delete();

    // retrun response
    return response([
        'message'=>'Data successfully Deleted',
        'status'=>true
    ]);

}
}
