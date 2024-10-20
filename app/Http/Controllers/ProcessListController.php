<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessModel;
class ProcessListController extends Controller
{
    //
    public function index()
    {
        return view('home');
    }

    public function process_add(Request $request){

        $request->validate([
            'add_process'=> 'required|string|max:255',
        ]);
        ProcessModel::create([
            'process' => $request->input('add_process'),
        ]);

        return redirect()->route('process_add.model.index')->with('success', 'Post created successfully!');
    }


}
