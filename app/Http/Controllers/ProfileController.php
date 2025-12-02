<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(StoreProfileRequest $requset)
    {
        $profile = Profile::create($requset->validated());
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
