<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="This is a sample API for demonstration purposes."
 * )
 * @OA\PathItem(
 *     path="/api"
 * )
 */
class HomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Retrieve a list of users",
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        return response()->json([
            'name' => $request->input('name'),
            'message' => 'Hello world!',
        ]);
    }
}
