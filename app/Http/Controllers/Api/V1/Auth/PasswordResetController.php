<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetpasswordRequest;
use App\Http\Requests\ResetNewPasswordRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    protected  PasswordResetService $passwordResetService;

    /**
     * Summary of __construct
     * @param \App\Services\PasswordResetService $passwordResetService
     */
    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }


    /**
     * Summary of sendResetPasswordEmail
     * @param \App\Http\Requests\Auth\ResetpasswordRequest $request
     */
    public function sendResetPasswordEmail(ResetpasswordRequest $request)
    {
        return  $this->successMessage(
            ["status" => $this->passwordResetService->sendResetPasswordEmail($request->validated())],
            'Successfully Send Information to Your email',
            200
        );
    }

    /**
     * Summary of resetPassword
     * @param \App\Http\Requests\ResetNewPasswordRequest $request
     */
    public function resetPassword(ResetNewPasswordRequest $request)
    {
        $data = $this->passwordResetService->resetPassword($request->validated());
        return $this->successMessage([$data], 'Successfully Reset Password', 201);
    }
}
