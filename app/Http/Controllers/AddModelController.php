<?php

namespace App\Http\Controllers;

use App\Models\AddModel;
use Illuminate\Http\Request;
use App\Models\Post;



class AddModelController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function add(Request $request)
    {

        $request->validate([
            'model_name' => 'required|string|max:255',
            'width' => 'required|numeric',
            'max_tolerance_width' => 'required|numeric',
            'min_tolerance_width' => 'required|numeric',
            'length' => 'required|numeric',
            'max_tolerance_length' => 'required|numeric',
            'min_tolerance_length' => 'required|numeric',
            'thickness' => 'required|numeric',
            'max_tolerance_thickness' => 'required|numeric',
            'min_tolerance_thickness' => 'required|numeric',
        ]);

        AddModel::create([
            'model_name' => $request->input('model_name'),
            'width' => $request->input('width'),
            'max_tolerance_width' => $request->input('max_tolerance_width'),
            'min_tolerance_width' => $request->input('min_tolerance_width'),
            'length' => $request->input('length'),
            'max_tolerance_length' => $request->input('max_tolerance_length'),
            'min_tolerance_length' => $request->input('min_tolerance_length'),
            'thickness' => $request->input('thickness'),
            'max_tolerance_thickness' => $request->input('max_tolerance_thickness'),
            'min_tolerance_thickness' => $request->input('min_tolerance_thickness'),
        ]);

        return redirect()->route('add.model.index')->with('success', 'Post created successfully!');
    }
}
