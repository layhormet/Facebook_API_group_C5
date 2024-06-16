<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return response()->json(["success" => true, "data" => $images], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $path = $image->store('images', 'public');
                $path = Storage::url($path);

                $image = Image::create(['image_url' => $path]);
                return response()->json(['success' => true, 'data' => $image, 'message' => 'File image uploaded successfully'], 201);
            }

            if ($request->input('image_url')) {
                $image_url = $request->input('image_url');
                $imageContents = file_get_contents($image_url);

                if ($imageContents === false) {
                    return response()->json(['error' => 'Failed to download image from URL'], 400);
                }

                $filename = 'images/' . Str::random(10) . '.' . pathinfo($image_url, PATHINFO_EXTENSION);
                Storage::disk('public')->put($filename, $imageContents);

                $image = Image::create(['image_url' => Storage::url($filename)]);
                return response()->json(['success' => true, 'data' => $image, 'message' => 'URL image uploaded successfully'], 201);
            }

            return response()->json(['error' => 'No image provided'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $image = Image::find($id);
        if ($image) {
            return response()->json(['success' => true, 'data' => $image], 200);
        }
        return response()->json(['error' => 'Image not found'], 404);
    }

    public function update(Request $request, string $id)
    {
        // Implement update logic if needed
    }

    public function destroy(string $id)
    {
        $image = Image::find($id);
        if ($image) {
            $imagePath = str_replace('/storage', '', $image->image_url);
            Storage::disk('public')->delete($imagePath);
            $image->delete();
            return response()->json(['success' => true, 'message' => 'Image deleted successfully'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }
}
