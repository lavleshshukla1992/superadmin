<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InformationResource;
use App\Http\Resources\ApiInformationCollection;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $informations = Information::select(
             'information.id',
             'information.title',
             'information.description',
             'information.information_link',
             'information.cover_image',
             'information.created_by',
             'information.updated_by',
         )
         ->orderBy('id', 'DESC')
         ->get()
         ->toArray();
         $informations = !is_null($informations) ? json_decode(json_encode($informations),true): [];

        return view('backend.pages.information.index',compact('informations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.information.create');
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 

        $request->validate([
            'information_link' => ['nullable','url'],
            'description' => ['required'],
        ]);
        $input = $request->all();
        //echo "<pre>"; print_r($input);die;
        if ($request->hasFile('cover_image')) {
            $media = $request->file('cover_image');
            $mediaName = time() . $media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['cover_image'] = $mediaName;
        }

        $information = Information::create($input);
        return redirect()->route('information.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        return view('backend.pages.information.detail',compact('information'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Information  $scheme
     * @return \Illuminate\Http\Response
     */
    public function edit(Information $information)
    { 
        $info_id = $information->id;
        $cover_image = $information->cover_image;
        return view('backend.pages.information.edit',compact('information'), ['info_id' => $info_id, 'cover_image' => $cover_image]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    { 
        $request->validate([
            'information_link' => ['nullable','url'],
            'description' => ['required'],
        ]);

        $cover_image = $request->file('cover_image');
        $input = $request->all();
        //dd($input['info_id']);
        if (! is_null($cover_image)) 
        {
            $mediaName = time().$cover_image->getClientOriginalName();
            $cover_image->move('uploads', $mediaName);
            $input['cover_image'] = $mediaName;

            Information::where('id', '=', $input['info_id'])
            ->update([
                'title' => $input['title'],
                'description' => $input['description'],
                'information_link' => $input['information_link'],
                'cover_image' => $input['cover_image'],
            ]);
        }
        else{
            Information::where('id', '=', $input['info_id'])
            ->update([
                'title' => $input['title'],
                'description' => $input['description'],
                'information_link' => $input['information_link'],
            ]);
        }

        
        
        //$information->fill($input);
        //$information->save();
        return redirect()->route('information.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        $information->delete();
        return redirect()->route('information.index');
        
    }

}
