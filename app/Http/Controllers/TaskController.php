<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $tasks = Task::paginate();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $task = new Task();
        $statuses = TaskStatus::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->all();
        $allUsers = User::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->all();

        return view('tasks.create', compact(['task', 'statuses', 'allUsers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:tasks',
            'description' => 'nullable|max:255',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable'
        ]);

        $userId = Auth::id();
        $user = User::find($userId);
        $status = TaskStatus::find($data['status_id']);
        $assignedUser = User::find($data['assigned_to_id']);

        $newTask = new Task($data);

        $newTask->creator()->associate($user);
        $newTask->status()->associate($status);
        $newTask->assignedUser()->associate($assignedUser);
        $newTask->save();

        flash(__('messages.created', ['name' => 'task']));

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return Application|Factory|View
     */
    public function edit(Task $task): View|Factory|Application
    {
        $task = Task::findOrFail($task->id);
        $statuses = TaskStatus::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->all();
        $allUsers = User::all()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->all();
        return view('tasks.edit', compact(['task', 'statuses', 'allUsers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return RedirectResponse
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $status = TaskStatus::findOrFail($task->id);
        $data = $this->validate($request, [
            'name' => 'required|unique:tasks,name,' . $status->id,
            'description' => 'nullable|max:255',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable'
        ]);

        $task->fill($data);
        $status = TaskStatus::find($data['status_id']);
        $assignedUser = User::find($data['assigned_to_id']);
        $task->status()->associate($status);
        $task->assignedUser()->associate($assignedUser);

        $task->save();

        flash(__('messages.updated', ['name' => 'task']));

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
