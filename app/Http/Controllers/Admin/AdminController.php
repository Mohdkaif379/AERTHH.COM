<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

   public function loginSubmit(Request $request)
{
    // validation
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // admin check
    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        return back()->with('error', 'Email not found')->withInput();
    }

    // password check
    if (!Hash::check($request->password, $admin->password)) {
        return back()->with('error', 'Wrong password')->withInput();
    }

    // Clear any existing sessions first
    session()->forget(['admin_id', 'admin_name', 'admin_email']);
    
    // Set new session
    session([
        'admin_id' => $admin->id,
        'admin_name' => $admin->name,
        'admin_email' => $admin->email,
    ]);

    // Regenerate session ID
    $request->session()->regenerate();

    return redirect()->route('admin.dashboard')
                 ->with('success', 'Login successful');
}

   public function logout(Request $request)
{
    // Clear all session data
    session()->forget(['admin_id', 'admin_name', 'admin_email']);
    session()->flush();
    
    // Regenerate session ID for security
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // Redirect with success message
    return redirect()->route('admin.login')
                 ->with('success', 'Logged out successfully');
}
}
