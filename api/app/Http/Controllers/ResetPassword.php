<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\ResetPasswordRequest;

class ResetPassword extends Controller
{
    /**
     * Set middleware to guest to prvent user auth
     * when sending password reset request.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    /**
     * Reset user password
     *
     * Passwords which are sent must be strong i.e. min. 8 characters
     *
     * @group Authentication
     * @bodyParam email string required Example: foo@bar.com
     * @bodyParam token string required One time reset token from email used for auth Example: YOUR_TOKEN_HERE
     * @bodyParam password string required New password Example: kwakwa5!
     * @bodyParam password_confirmation required Password confirmation Example: kwakwa5!
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = $password;
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? ['message' => __($status)]
            : response()->json(['message' => 'Could not reset password', 'errors' => ['status' => __($status)]], 401);
    }
}
