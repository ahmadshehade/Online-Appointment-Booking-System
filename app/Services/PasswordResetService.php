<?php

namespace App\Services;

use App\Events\ResetPasswordEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PasswordResetService
{


    /**
     * Summary of sendResetPasswordEmail
     * @param array $data
     * @return bool
     */
    public function  sendResetPasswordEmail(array $data)
    {
        try {
            $user = User::where("email", $data["email"])->firstOrFail();
            $token = Str::random(64);
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
             Log::info('Token Password:  '.$token);
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]);

            $resetLink = url("/reset-password'?token=$token&email=" . urlencode($user->email));
            event(new ResetPasswordEvent($resetLink, $user));
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function resetPassword(array $data)
    {
        try {
            $record = DB::table('password_reset_tokens')->where('email', $data['email'])->firstOrFail();
            if (!$record) {
                throw new \Exception('Invalid or expired token.');
            }
            if (!Hash::check($data['token'], $record->token)) {
                throw new \Exception('Invalid token.');
            }

            if (Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
                throw new \Exception('Token expired.');
            }

            $user = User::where('email', $data['email'])->firstOrFail();
            $user->password = Hash::make($data['password']);
            $user->save();
            DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
