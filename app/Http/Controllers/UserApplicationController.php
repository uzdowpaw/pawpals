<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;

class UserApplicationController extends Controller
{
    public function index()
    {
        $applications = AdoptionApplication::where('user_id', Auth::id())
            ->where('dog_type', 'shelter_dog') 
            ->with('dog.shelter')
            ->latest()
            ->get();

        return view('user.applications.index', ['applications' => $applications]);
    }
}
