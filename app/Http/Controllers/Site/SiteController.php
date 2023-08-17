<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    function index() {
        return view('site.home');
    }

    function beginningRegistration($locale) {
        return view("auth.registration.registrationType");
    }

    function businessRegistration($locale) {
        return view("auth.registration.businessRegistration");
    }

    function clientRegistration($locale) {
        return view("auth.registration.clientRegistration");
    }

    function termsConditionsPage($locale) {
        return view("site.TermsConditionsPage");
    }
}
