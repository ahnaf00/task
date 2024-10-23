<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('home');
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image'
        ]);

        if($request->hasFile('image'))
        {
            $image          = $request->file('image');
            $time           = time();
            $fileName       = $image->getClientOriginalName();
            $imageName      = "{$time}-{$fileName}";
            $image->move(public_path('uploads/profile_images'), $imageName);

            $user = auth()->user();
            $user->image = 'uploads/profile_images/'.$imageName;
            $user->save();

            return response()->json(['success' => true, 'image' => $user->image]);

        }
        return response()->json(['success' => false, 'message' => 'File not uploaded']);

    }

    public function products()
    {
        return view('products');
    }
}
