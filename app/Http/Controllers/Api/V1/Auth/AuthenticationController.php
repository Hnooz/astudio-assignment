<?php 
namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        return response()->json(['message' => 'Login']);
    }

    public function register(StoreUserRequest $request)
    {
        User::create($request->validated());
        return $this->sendSuccessResponse(data: [], message: 'User registered successfully');
    }

    public function logout()
    {
        return response()->json(['message' => 'Logout']);
    }
}