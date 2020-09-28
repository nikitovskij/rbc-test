<?php

namespace App\Http\Controllers;

use App\Models\RbcNews;
use Illuminate\Http\Request;

class LocalNewsController extends Controller
{
    public function index()
    {
        $news = RbcNews::latest('date_modified')->paginate(15);

        return view('index', compact('news'));
    }

    public function show($id)
    {
        $article = RbcNews::where('feed_id', $id)->firstOrFail();

        return view('article', compact('article'));
    }
}
