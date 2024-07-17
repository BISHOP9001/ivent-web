<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response | \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $errors = [];

        if (!$user || !Hash::check($request->password, $user->password)) {
            $errors[] = "Invalid login username or password";
        }

        $authDenied = "You don't have the required role or privilege to complete this action";
        $viewPage = null;
        $prefix = $request->route()->getPrefix();
        //dd($user->hasRole('admin'));

        switch ($prefix) {
            case '/admin':
                $viewPage = "auth.admin.login";
                if ($user && !$user->hasRole('admin')) {
                    $errors[] = $authDenied;
                }
                break;
        }

        if (count($errors) > 0)
            //return response()->json($errors, 401);
            return $this->view($viewPage, ["errors" => $errors]);

        $request->authenticate();

        $user = Auth::user();
        $user = User::find($user->id);

        $request->session()->regenerate();

        return redirect()->intended('/admin/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
