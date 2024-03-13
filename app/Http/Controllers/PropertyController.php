<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $properties = Property::latest()->paginate(5);
    
        return view('backend.properties.index', compact('properties'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'price' => 'required',
            'type' => 'required',
            'detail' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $input = $request->all();
    
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
      
        Property::create($input);
       
        return redirect()->route('properties.index')
                        ->with('success','Property created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        return view('backend.properties.edit',compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'price' => 'required',
            'type' => 'required',
            'detail' => 'required',
        ]);
    
        $input = $request->all();
    
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }
            
        $property->update($input);
      
        return redirect()->route('properties.index')
                        ->with('success','Property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
         
        return redirect()->route('properties.index')
                        ->with('success','Property deleted successfully');
    }

}
