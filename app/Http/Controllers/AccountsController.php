<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class AccountsController extends Controller
{
 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.accounts');
    }

    public function users_list(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $perPage = $request->input('perPage', 10); // Default to 10 items per page

        $query = User::query();

        // Exclude admin accounts
        $query->where('role', '!=', 'admin');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', '%' . $search . '%')
                ->orWhere('lastname', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%');
            });
        }

        if ($role && $role !== 'all') {
            $query->where('role', $role);
        }

        $users = $query->paginate($perPage);

        return UserResource::collection($users);
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        return response()->json(['data' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {
        $request->validate([
            'prefix' => 'nullable|string|max:10',
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'role' => 'required|string',
            'contact' => 'required|string|max:15',
            'email' => 'required|string|email|unique:users,email,' . $userId,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::findOrFail($userId);

        $imagePath = $user->profile_image;  

        if ($request->hasFile('profile_image')) {

            $imagePath = '/storage/' . $request->file('profile_image')->store('profile_images', 'public');
        }


        $user->update([
            'prefix' => $request->input('prefix'),
            'name' => $request->input('firstname'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'role' => $request->input('role'),
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'profile_image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'user' => $user,
        ]);
    }

    public function update_status(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->update([
            'user_status' => $request->input('user_status')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
       
    }
}
