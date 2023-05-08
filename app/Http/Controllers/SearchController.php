<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::where('username', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->get();

        return view('search.index', compact('users', 'searchTerm'));
    }
}
