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
	public function our_services()
    {
        return view('pages.our-services');
        
    }
	public function nursing_services()
    {
        return view('pages.nursing-services');
        
    }
	public function health_aid_services()
    {
        return view('pages.health-aid-services');
        
    }
	public function physical_occupational_services()
    {
        return view('pages.physical-occupational-services');
        
    }
	public function revival_university()
    {
        return view('pages.revival-university');
        
    }
	public function waiver_program()
    {
        return view('pages.waiver-program');
        
    }
    public function careers()
    {
        return view('pages.careers');
        
    }
    public function resources()
    {
        return view('pages.resources');
        
    }
    public function contact()
    {
        return view('pages.contact');
        
    }
	
	
	
}
