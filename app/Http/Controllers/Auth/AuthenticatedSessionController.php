<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\PetCareReminder;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect admin users to admin dashboard
        if (auth()->user()->role === 'admin') {
            return redirect(route('admin.dashboard', absolute: false));
        } elseif (auth()->user()->role === 'shelter') {
            return redirect(route('shelter.dashboard', absolute: false));
        } elseif (auth()->user()->role === 'user') {
            $user = auth()->user();
            $upcomingReminders = PetCareReminder::where('user_id', $user->id)
                ->whereBetween('reminder_date', [Carbon::now(), Carbon::now()->addWeek()])
                ->get();

            \Illuminate\Support\Facades\Log::info('Upcoming Reminders: ' . $upcomingReminders->toJson());
            if ($upcomingReminders->isNotEmpty()) {
                $request->session()->flash('upcoming_reminders', $upcomingReminders);
            }
            return redirect(route('user.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
