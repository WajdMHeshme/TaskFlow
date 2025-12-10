<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function store(StoreProfileRequest $requset)
    {
        $user_id = Auth::user()->id;
        $validatedData = $requset->validated();
        $validatedData['user_id'] = $user_id;
        if ($requset->hasFile('image')) {
            $photo_path = $requset->file('image')->store('photos', 'public');
            $validatedData['image'] = $photo_path;
        }
        $profile = Profile::create($validatedData);
        return response()->json([
            'message' => 'profile created successfuly',
            'profile' => $profile,
            'status' => 201
        ]);
    }

    public function show($id)
    {
        $profile =  Profile::where('user_id', $id)->firstOrFail();
        return response()->json($profile);
    }

    public function showProfile($id)
    {
        $profile =  Profile::where('id', $id)->firstOrFail();
        return response()->json($profile);
    }

    public function edite(UpdateProfileRequest $requset, $id)
    {
        $profile = Profile::find($id);
        $profile->update($requset->validated());
        return response()->json([
            'message' => 'profile updated successfuly',
            'profile' => $profile
        ]);
    }
}
