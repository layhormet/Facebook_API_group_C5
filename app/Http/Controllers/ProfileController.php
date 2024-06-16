<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ShowProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // /
    //  * Display a listing of the resource.
    //  */
    public function index(Request $request)
    {
        $profiles = Profile::with(['image', 'user'])->get();
         $profiles= ProfileResource::collection($profiles);
        return response(['success' => true, 'data' => $profiles], 200);
    }

    // /
    //  * Store a newly created resource in storage.
    //  */
    public function store(ProfileRequest $request)
    {
        $profile = Profile::createOrUpdate($request);
        return response()->json(["success" => true, "data" => $profile, "Message" => "Profile created successfully"]);
    }

    // /
    //  * Display the specified resource.
    //  */
    public function show(string $id)
    {
        $profile = Profile::with(['image', 'user'])->find($id);
        $profile = new ShowProfileResource($profile);
        if ($profile) {
            return ["success" => true, "data" => $profile];
        }
        return ["success" => false, "Message" => "Profile not found"];
    }

    // /
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, string $id)
    {
        $profile = Profile::createOrUpdate($request, $id);
        return ["success" => true, "Message" => "Profile updated successfully", "data" => $profile];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = Profile::find($id);
        if ($profile) {
            $profile->delete();
            return ["success" => true, "Message" => "Profile deleted successfully"];
        }
        return ["success" => false, "Message" => "Profile not found"];
    }
}