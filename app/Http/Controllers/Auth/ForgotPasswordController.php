<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordManual;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // public function sendResetLinkEmail(Request $request)
    // {
    //     // $request->validate(['email' => 'required|email']);

    //     // // Look up the user by email in the related Karyawan model
    //     // $user = User::whereHas('karyawan', function ($query) use ($request) {
    //     //     $query->where('email', $request->email);
    //     // })->first();

    //     // if (!$user) {
    //     //     return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
    //     // }

    //     // // Inject the email into the credentials manually
    //     // $credentials = ['email' => $request->email];
    //     // // print_r($credentials);
    //     // // Send the reset link
    //     // return Password::sendResetLink($credentials)
    //     //     ? back()->with('status', trans(Password::RESET_LINK_SENT))
    //     //     : back()->withErrors(['email' => trans(Password::INVALID_USER)]);
    //     $request->validate(['email' => 'required|email']);

    //     // Find the user by the related Karyawan's email
    //     $user = User::whereHas('karyawan', function ($query) use ($request) {
    //         $query->where('email', $request->email);
    //     })->first();

    //     if (!$user) {
    //         return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
    //     }

    //     // Manually create a reset token
    //     $token = Password::broker()->createToken($user);
    //     // Send the reset notification
    //     $user->notify(new ResetPassword($token));

    //     return back()->with('status', trans(Password::RESET_LINK_SENT));
    // }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::whereHas('karyawan', function ($query) use ($request) {
            $query->where('email', $request->email);
        })->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        try {

            $token = Password::broker()->createToken($user);

            // Debug token output
            Log::info('Generated reset token: ' . $token);

            Mail::to($user->karyawan->email)->send(new ResetPasswordManual($token));

            return back()->with('status', trans(Password::RESET_LINK_SENT));
        } catch (\Throwable $e) {
            // Log the error
            Log::error('Password reset email failed: ' . $e->getMessage());

            dd($e->getMessage());

            return back()->withErrors([
                'email' => 'Failed to send password reset email. Check logs for details.',
            ]);
        }
    }
}
