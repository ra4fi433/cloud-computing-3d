<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    //
    // Show the form
    public function showForm()
    {
        return view('form'); // View file: resources/views/form.blade.php
    }
}
