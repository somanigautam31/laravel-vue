<?php

namespace App\Http\Controllers;
use App\Models\User; // Import the User model
use Illuminate\Http\Request;

class UserController extends Controller
{
    // app/Http/Controllers/UserController.php

public function index()
{
    return User::all();
}

public function store(Request $request)
{
    return User::create($request->all());
}

public function show(User $user)
{
    return $user;
}

public function update(Request $request, User $user)
{
    $user->update($request->all());
    return $user;
}

public function destroy(User $user)
{
    $user->delete();
    return response()->json(null, 204);
}

}
