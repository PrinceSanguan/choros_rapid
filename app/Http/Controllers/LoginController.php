<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Update last login time
            $user = Auth::user();
            DB::table('users')->where('id', $user->id)->update(['last_login_at' => now()]);

            // Redirect based on user role
            switch ($user->position) {
                case 'admin':
                    return redirect()->route('admin_dashboard');
                case 'project-manager':
                    return redirect()->route('project_manager_dashboard');
                case 'accountant':
                    return redirect()->route('accountant_dashboard');
                case 'inventory-staff':
                    return redirect()->route('inventory_dashboard');
                case 'supplier':
                    return redirect()->route('supplier_dashboard');
                default:
                    return redirect()->route('welcome');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Password reset logic would go here
        // This is a simplified version
        return back()->with('status', 'Password reset link sent!');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Registration logic would go here
        return redirect()->route('login');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        // Password reset logic would go here
        return redirect()->route('login');
    }
}
