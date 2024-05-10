<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('layouts.index');
    }

    public function importation()
    {
        return view('layouts.importer_fichiers');
    }

    public function constitution()
    {
        return view('layouts.constituer_jury');
    }

    public function generation()
    {
        return view('layouts.generer_planning');
    }


}
