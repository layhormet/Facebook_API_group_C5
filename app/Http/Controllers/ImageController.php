<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
/**
 * @OA\Info(title="My API", version="1.0")
 */
class ImageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/profiles",
     *     summary="Get list of profiles",
     *     tags={"Profiles"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Profile")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     */
    
    public function index()
    {
        $images = Image::all();
        return response()->json(["success" => true, "data" => $images], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_url' => 'required_without:file|url',
            'file' => 'required_without:image_url|file|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            if ($request->hasFile('file')) {
                $image = $request->file('file');
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
        $validator = Validator::make($request->all(), [
            'image_url' => 'required_without:file|url',
            'file' => 'required_without:image_url|file|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $image = Image::find($id);
            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            if ($request->hasFile('file')) {
                // Delete the old image file
                $oldImagePath = str_replace('/storage', '', $image->image_url);
                Storage::disk('public')->delete($oldImagePath);

                // Store the new image file
                $file = $request->file('file');
                $path = $file->store('images', 'public');
                $path = Storage::url($path);

                // Update the image URL in the database
                $image->update(['image_url' => $path]);
                return response()->json(['success' => true, 'data' => $image, 'message' => 'File image updated successfully'], 200);
            }

            if ($request->input('image_url')) {
                // Delete the old image file
                $oldImagePath = str_replace('/storage', '', $image->image_url);
                Storage::disk('public')->delete($oldImagePath);

                // Store the new image from URL
                $image_url = $request->input('image_url');
                $imageContents = file_get_contents($image_url);

                if ($imageContents === false) {
                    return response()->json(['error' => 'Failed to download image from URL'], 400);
                }

                $filename = 'images/' . Str::random(10) . '.' . pathinfo($image_url, PATHINFO_EXTENSION);
                Storage::disk('public')->put($filename, $imageContents);

                // Update the image URL in the database
                $image->update(['image_url' => Storage::url($filename)]);
                return response()->json(['success' => true, 'data' => $image, 'message' => 'URL image updated successfully'], 200);
            }

            return response()->json(['error' => 'No image provided'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        return response()->json(['error' => 'Image not found'], 404);
    }
}
