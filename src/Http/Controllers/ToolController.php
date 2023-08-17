<?php

namespace Mdeskorg\Settings\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Validation\Rules\Password;

class ToolController extends Controller
{
    public function index()
    {
        return response()->json([
            'props' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ]);
    }

    public function setInfo()
    {
        $data = request()->validate([
            'name' => ['required', 'min:2', 'max:32'],
        ]);

        auth()->user()->update($data);

        return response()->json([]);
    }

    public function changePassword()
    {
        $data = request()->validate([
            'currentPassword' => ['required', 'string', 'current_password:web'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => bcrypt($data['password']),
        ]);

        return response()->json([]);
    }
}
