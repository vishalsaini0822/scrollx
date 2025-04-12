<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Show form to request reset link
    public function showLinkRequestForm()
    {
        return view('forget');
    }

    // Send reset link to email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(60);
        $password = Str::random(10);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        DB::table('users')->updateOrInsert(
            ['email' => $request->email],
            ['password' => Hash::make($password), 'created_at' => Carbon::now()]
        );

        $link = url('/reset-password?token=' . $token . '&email=' . urlencode($request->email));

        Mail::raw("Your new password is for scrollx is : $password", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Password recovery');
        });

        return back()->with('message', 'Your password has been sent on your mail.');
    }

    // Show password reset form
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }

    // Handle new password submission
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'This reset link is invalid or expired.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset. You can now log in.');
    }
}

