<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Retrieve all registered users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ensure the user is authorized to view the list of users
        Gate::authorize('view-any', User::class);

        // Retrieve all users
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Retrieve a specific user by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        // Ensure the user is authorized to view a specific user
        Gate::authorize('view', $id);

        // Retrieve the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }
}