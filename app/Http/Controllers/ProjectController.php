<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = \App\Models\Customer::orderBy('name')->get();
        return view('projects.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'contractor' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'project_manager' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,ongoing,completed',
            'budget' => 'nullable|numeric',
            'customer_id' => 'nullable|exists:customers,id',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        // Create the project
        $project = Project::create($validated);

        // Create a schedule for this project
        $startDate = $validated['start_date'] ?? now();

        $scheduleData = [
            'title' => $validated['name'],
            'description' => $validated['description'] ?? "Project at {$validated['location']}",
            'start_date' => $startDate,
            'end_date' => null, // Can be set later
            'status' => 'scheduled',
            'project_id' => $project->id,
            'user_id' => Auth::id(),
        ];

        // Create the schedule
        Schedule::create($scheduleData);

        return redirect()->route('projects.index')->with('success', 'Project created successfully and added to calendar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $customers = \App\Models\Customer::orderBy('name')->get();
        return view('projects.edit', compact('project', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'contractor' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'project_manager' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,ongoing,completed',
            'budget' => 'nullable|numeric',
            'customer_id' => 'nullable|exists:customers,id',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        try {
            $project->update($validated);

            // Update the associated schedule if it exists, or create a new one
            $schedule = Schedule::where('project_id', $project->id)->first();

            $scheduleData = [
                'title' => $validated['name'],
                'description' => $validated['description'] ?? "Project at {$validated['location']}",
                'start_date' => $validated['start_date'] ?? now(),
                'status' => ($validated['status'] ?? null) == 'completed' ? 'completed' : 'scheduled',
            ];

            if ($schedule) {
                $schedule->update($scheduleData);
            } else {
                $scheduleData['project_id'] = $project->id;
                $scheduleData['user_id'] = Auth::id();
                Schedule::create($scheduleData);
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Project updated successfully and calendar updated.',
                    'redirect' => route('projects.index')
                ]);
            }

            return redirect()->route('projects.index')->with('success', 'Project updated successfully and calendar updated.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['update_error' => 'Failed to update project. ' . $e->getMessage()]
                ]);
            }

            return back()->withInput()->withErrors(['update_error' => 'Failed to update project. ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Schedule will be automatically deleted due to cascade delete in migration
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
