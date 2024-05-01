<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;



class ScheduleController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $query = $request->input('query');
    if ($query) {

        $schedules = Schedule::search($query)->get();


        var_dump($query);
    } else {
        // Determine which schedules to retrieve based on user role
        if ($user && $user->role === 'admin') {
          
            // If the user is an admin, retrieve all schedules
            $schedules = Schedule::with('user')->get();
        } else {
            

            // If the user is not an admin, retrieve schedules for the current user only
            $schedules = Schedule::where('user_id', $user->id)->with('user')->get();
        }
    }
  
    // Pass the schedules data and query parameter to the view
    return view('dashboard', compact('schedules', 'query'));
}    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }
    public function update(Request $request, Schedule $schedule)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|max:255',
        ]);

        // Update the schedule with the validated data
        $schedule->update($validatedData);

        // Redirect back to a relevant page (e.g., index or show) with a success message
        return redirect()->route('dashboard')->with('success', 'Schedule updated successfully.');
    }
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);

        // Display confirmation alert to the user
        return view('schedules.confirm-delete', compact('schedule'));
    }

    public function delete(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        // Delete the schedule
        $schedule->delete();

        // Redirect back to a relevant page (e.g., index) with a success message
        return redirect()->route('dashboard')->with('success', 'Schedule deleted successfully.');
    }

    public function create()
    {
        $users = User::where('role', '!=', 'admin')->get();

        return view('schedules.create', compact('users'));
       
    }
    public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'location' => 'nullable|max:255',
    ]);

    // Check if the authenticated user is an admin
    if (Auth::user()->role === 'admin') {
        // If the user is an admin, allow them to input the user_id
        $validatedData['user_id'] = $request->input('user_id');
    } else {
        // If the user is not an admin, set the user_id based on the authenticated user
        $validatedData['user_id'] = Auth::id();
    }

    // Create a new schedule instance
    Schedule::create($validatedData);

    // Redirect back to a relevant page (e.g., index) with a success message
    return redirect()->route('dashboard')->with('success', 'Schedule added successfully.');
}


public function notification()
{
    // Get the currently authenticated user's user_id
    $userId = Auth::id();

    // Get the current date and time
    $now = Carbon::now();

    // Calculate the date and time 2 days from now
    $twoDaysLater = $now->copy()->addDays(2);

    // Retrieve schedules due within the next 2 days for the authenticated user
    $schedulesDue = Schedule::where('end_time', '>=', $now)
    ->where('end_time', '<=', $twoDaysLater)
    ->where('user_id', $userId)
    ->orderBy('end_time', 'asc')
    ->get(['title', 'description', 'start_time', 'end_time', 'location']);


    return view('notification', [
        'schedulesDue' => $schedulesDue,
        'twoDaysLater' => $twoDaysLater,
    ]);
}

}