<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Gig;
use File;

class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gig::all();
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
         // validate gig form request

       $validation = $request->validate([
            'gig_title'=>'required|unique:gigs|max:250',
            'gig_image_one' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'gig_image_two' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'gig_image_three' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'gig_star' =>'required | max:5',
            'gig_rating' =>'required',
            'delivery_time' =>'required',
            'price' => 'required'
        ]);

        //naming and storing image one
        if($validation){
            if($request->hasFile("gig_image_one")){
        $ext1 = $request->gig_image_one->getClientOriginalExtension();
        $gig_image_one = time().'gig_image_one'.'.'.$ext1;
        $request->gig_image_one->move(public_path() . '/gigs/', $gig_image_one);
            }
         //naming and storing image two
         if($request->hasFile("gig_image_two")){
         $ext2 = $request->gig_image_two->getClientOriginalExtension();
         $gig_image_two = time().'gig_image_two'.'.'.$ext2;
         $request->gig_image_two->move(public_path() . '/gigs/', $gig_image_two);
         }
         
          //naming and storing image three
          if($request->hasFile("gig_image_three")){
          $ext3 = $request->gig_image_three->getClientOriginalExtension();
          $gig_image_three = time().'gig_image_three'.'.'.$ext3;
          $request->gig_image_three->move(public_path() . '/gigs/', $gig_image_three);
          }
        }
        // saving fields:

        $gig = Gig::create([
            'gig_title' => $request->gig_title,
            'gig_image_one' => $gig_image_one,
            'gig_image_two' => $gig_image_two,
            'gig_image_three' => $gig_image_three,
            'gig_star' => $request->gig_star,
            'gig_rating' => $request->gig_rating,
            'delivery_time' => $request->delivery_time,
            'price' => $request->price,
        ]);
        $gig->save();

        // returning response

        return response([
            'message'=>'Gig successfully Created',
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
        return Gig::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Gig::find($id);

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
        $gig = Gig::find($id);

       $validation = $request->validate([
            'gig_title'=>'required | max:250',
            'gig_image_one' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'gig_image_two' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'gig_image_three' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'gig_star' =>'required | max:5',
            'gig_rating' =>'required',
            'delivery_time' =>'required',
            'price' => 'required'
        ]);

        if($validation){

                //naming and storing image one
                if($request->hasFile("gig_image_one")){
                $old_gig_image_one = $request->gig_image_one;
                $ext1 = $request->gig_image_one->getClientOriginalExtension();
                $gig_image_one = time().'gig_image_one'.'.'.$ext1;
                $request->gig_image_one->move(public_path() . '/gigs/', $gig_image_one);
                }
                if($request->hasFile("gig_image_two")){
                 //naming and storing image two
                 $old_gig_image_two = $request->gig_image_two;
                 $ext2 = $request->gig_image_two->getClientOriginalExtension();
                 $gig_image_two =time().'gig_image_two'.'.'.$ext2;
                 $request->gig_image_two->move(public_path() . '/gigs/', $gig_image_two);
                }
                if($request->hasFile("gig_image_three")){
                  //naming and storing image three
                  $old_gig_image_three = $request->gig_image_three;
                  $ext3 = $request->gig_image_three->getClientOriginalExtension();
                  $gig_image_three = time().'gig_image_three'.'.'.$ext3;
                  $request->gig_image_three->move(public_path() . '/gigs/', $gig_image_three);
                }
        }
                // saving fields:
        
                $gig->update([
                    'gig_title' => $request->gig_title,
                    'gig_image_one' => $gig_image_one,
                    'gig_image_two' => $gig_image_two,
                    'gig_image_three' => $gig_image_three,
                    'gig_star' => $request->gig_star,
                    'gig_rating' => $request->gig_rating,
                    'delivery_time' => $request->delivery_time,
                    'price' => $request->price,
                ]);
                
                File::delete(public_path() . '/gigs/'.$old_gig_image_one);
                File::delete(public_path() . '/gigs/'.$old_gig_image_two);
                File::delete(public_path() . '/gigs/'.$old_gig_image_three);
        
                // returning response
        
                return response([
                    'message'=>'Gig successfully Updated',
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
        $gig = Gig::find($id);

        File::delete(public_path() . '/gigs/'.$gig->gig_image_one);
        File::delete(public_path() . '/gigs/'.$gig->gig_image_two);
        File::delete(public_path() . '/gigs/'.$gig->gig_image_three);

        $gig->delete();

        // retrun response
        return response([
            'message'=>'Gig successfully Deleted',
            'status'=>true
        ]);

    }
}
