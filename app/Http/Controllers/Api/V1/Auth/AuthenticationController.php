<?php 
namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Validation\Rules\Password;

 /**
 * @group Authentications
 *
 * This set of endpoints lets user to interact with OnBoarding
 */
class AuthenticationController extends Controller
{
     /**
     * Login to the platform
     *
     * This endpoint allow user Login to the platform
     *
     * @unauthenticated
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', Password::default()],
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid user credentials.',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('API Token')->accessToken;

        return $this->sendSuccessResponse(data: [
            'token' => $token,
            'user' => $user
        ], message: 'User login successfully');
    }

    /**
     * Register to the platform
     *
     * This endpoint allow user Register to the platform
     *
     * @unauthenticated
     */
    
    public function register(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        $token = $user->createToken('API Token')->accessToken;

        return $this->sendSuccessResponse(data: [
            'token' => $token,
            'user' => $user
        ], message: 'User registered successfully');
    }

     /**
     * logout
     *
     * This endpoint allow user to logout from our portal
     *
     * @authenticated
     */

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendSuccessResponse(message: 'User logged out successfully');
    }
}