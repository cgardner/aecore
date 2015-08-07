<?php namespace App\Http\Controllers;

use App\Http\Requests;

class LandingController extends Controller
{
    public function comingSoon()
    {
        return view('landing.coming-soon')
            ->with('landingTheme', 'theme7');
    }
}
