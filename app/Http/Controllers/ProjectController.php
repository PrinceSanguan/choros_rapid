<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::with('manager')->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $managers = User::whereHas('roles', function($query) {
            $query->where('slug', 'project-manager');
        })->get();

        return view('projects.create', compact('managers'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contractor' => 'required|string|max:255',
            'project_size' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $project->load('manager', 'billingTransactions');
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $managers = User::whereHas('roles', function($query) {
            $query->where('slug', 'project-manager');
        })->get();

        return view('projects.edit', compact('project', 'managers'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contractor' => 'required|string|max:255',
            'project_size' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,ongoing,completed,cancelled',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    /**
     * Display the project registration page.
     */
    public function registration()
    {
        $projects = Project::with('manager')->latest()->paginate(10);
        return view('projects.registration', compact('projects'));
    }
}
