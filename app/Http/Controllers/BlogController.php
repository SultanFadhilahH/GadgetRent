<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = \App\Models\Blog::orderBy('published_at', 'desc')->paginate(12);
        return view('customer.blog', compact('blogs'));
    }
}
