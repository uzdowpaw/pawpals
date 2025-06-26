<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\PetCareReminder;
use App\Models\PetCareLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PetCareController extends Controller
{
    /**
     * Display the pet care dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $pets = Dog::where('user_id', $user->id)->with(['petCareReminders', 'petCareLogs'])->get();

        // Check if user has no pets and redirect with popup message
        if ($pets->count() === 0) {
            return redirect()->route('user.pets.index')
                ->with('info', 'There is no pet registered to your account! Visit My Pet tab and add one!');
        }

        $upcomingReminders = PetCareReminder::where('user_id', $user->id)
            ->with('dog')
            ->upcoming()
            ->limit(5)
            ->get();

        $overdueReminders = PetCareReminder::where('user_id', $user->id)
            ->with('dog')
            ->overdue()
            ->get();

        $recentLogs = PetCareLog::where('user_id', $user->id)
            ->with('dog')
            ->recent(7)
            ->limit(10)
            ->get();

        return view('user.pet-care.index', compact('pets', 'upcomingReminders', 'overdueReminders', 'recentLogs'));
    }

    /**
     * Show reminders for a specific pet.
     */
    public function petReminders(Dog $pet)
    {
        if (!Auth::user()->can('view', $pet)) {
            abort(403, 'Unauthorized action.');
        }

        $reminders = $pet->petCareReminders()
            ->orderBy('reminder_date', 'asc')
            ->paginate(10);

        return view('user.pet-care.reminders', compact('pet', 'reminders'));
    }

    /**
     * Show the form for creating a new reminder.
     */
    public function createReminder(Dog $pet)
    {
        $this->authorize('view', $pet);

        return view('user.pet-care.create-reminder', compact('pet'));
    }

    /**
     * Store a newly created reminder.
     */
    public function storeReminder(Request $request, Dog $pet)
    {
        $this->authorize('view', $pet);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:feeding,medication,grooming,vet_visit,exercise,training,other',
            'reminder_date' => 'required|date|after:now',
            'frequency' => 'required|in:once,daily,weekly,monthly',
        ]);

        $pet->petCareReminders()->create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'reminder_date' => $validated['reminder_date'],
            'frequency' => $validated['frequency'],
        ]);

        return redirect()->route('user.pet-care.pet.reminders', $pet)
            ->with('success', 'Reminder created successfully!');
    }

    /**
     * Mark a reminder as completed.
     */
    public function completeReminder(Request $request, PetCareReminder $reminder)
    {
        $this->authorize('update', $reminder);

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $reminder->markAsCompleted($validated['notes']);

        // Create a care log entry
        PetCareLog::create([
            'user_id' => $reminder->user_id,
            'dog_id' => $reminder->dog_id,
            'reminder_id' => $reminder->id,
            'activity_type' => $reminder->type,
            'title' => $reminder->title,
            'description' => $reminder->description,
            'performed_at' => now(),
            'notes' => $validated['notes'],
        ]);

        return back()->with('success', 'Reminder marked as completed!');
    }

    /**
     * Show care logs for a specific pet.
     */
    public function petLogs(Dog $pet)
    {
        $this->authorize('view', $pet);

        $logs = $pet->petCareLogs()
            ->orderBy('performed_at', 'desc')
            ->paginate(15);

        return view('user.pet-care.logs', compact('pet', 'logs'));
    }

    /**
     * Show the form for creating a new care log.
     */
    public function createLog(Dog $pet)
    {
        $this->authorize('view', $pet);

        return view('user.pet-care.create-log', compact('pet'));
    }

    /**
     * Store a newly created care log.
     */
    public function storeLog(Request $request, Dog $pet)
    {
        $this->authorize('view', $pet);

        $validated = $request->validate([
            'activity_type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'performed_at' => 'required|date',
            'notes' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'temperature' => 'nullable|numeric|min:0',
        ]);

        $metadata = [];
        if ($request->filled('weight')) {
            $metadata['weight'] = $validated['weight'];
        }
        if ($request->filled('temperature')) {
            $metadata['temperature'] = $validated['temperature'];
        }

        $pet->petCareLogs()->create([
            'user_id' => Auth::id(),
            'activity_type' => $validated['activity_type'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'performed_at' => $validated['performed_at'],
            'notes' => $validated['notes'],
            'metadata' => !empty($metadata) ? $metadata : null,
        ]);

        return redirect()->route('pet-care.pet.logs', $pet)
            ->with('success', 'Care log created successfully!');
    }

    /**
     * Delete a reminder.
     */
    public function deleteReminder(PetCareReminder $reminder)
    {
        $this->authorize('delete', $reminder);

        $reminder->delete();

        return back()->with('success', 'Reminder deleted successfully!');
    }

    /**
     * Delete a care log.
     */
    public function deleteLog(PetCareLog $log)
    {
        $this->authorize('delete', $log);

        $log->delete();

        return back()->with('success', 'Care log deleted successfully!');
    }
}
