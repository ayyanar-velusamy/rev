<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function index()
    {
        return view('pages.index');
        
    }
	
	public function about()
    {
        return view('pages.about');
        
    }
	public function history()
    {
        return view('pages.history');
        
    }
	public function quality_measures()
    {
        return view('pages.quality-measures');
        
    }
	
	
}
