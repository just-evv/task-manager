<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $tasks = Task::all();

        $filter = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')])
            ->paginate(15);

        return view('tasks.index', compact('filter', 'statuses', 'users', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $this->authorize('create', Task::class);
        $task = new Task();
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.create', compact(['task', 'statuses', 'users', 'labels']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @throws ValidationException
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $userId = Auth::id();
        $user = User::find($userId);
        $status = TaskStatus::find($data['status_id']);

        $task = new Task($data);

        $task->creator()->associate($user);
        $task->status()->associate($status);
        $task->save();

        if (array_key_exists('assigned_to_id', $data)) {
            $assignedUser = User::find($data['assigned_to_id']);
            $task->assignedUser()->associate($assignedUser);
        }
        if (array_key_exists('labels', $data)) {
            $label = Label::find($data['labels'][0]);
            $task->labels()->attach($label);
        }
        $task->save();

        flash(__('messages.task.created'));
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return Application|Factory|View
     */
    public function show(Task $task): View|Factory|Application
    {
        $task = Task::findOrFail($task->id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return Application|Factory|View
     */
    public function edit(Task $task): View|Factory|Application
    {
        $this->authorize('edit', Task::class);
        $statuses = TaskStatus::pluck('name', 'id');
        $allUsers = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('tasks.edit', compact(['task', 'statuses', 'allUsers', 'labels']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('update', Task::class);
        $data = $request->validated();

        $task->fill($data);

        $status = TaskStatus::find($data['status_id']);

        $task->status()->associate($status);
        if (array_key_exists('assigned_to_id', $data)) {
            $assignedUser = User::find($data['assigned_to_id']);
            $task->assignedUser()->associate($assignedUser);
        }
        if (array_key_exists('labels', $data)) {
            $label = Label::find($data['labels'][0]);
            $task->labels()->attach($label);
        }
        $task->save();

        flash(__('messages.task.updated'));

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);
        $task->labels()->detach();
        $task->delete();
        flash(__('messages.task.deleted'));
        return redirect()->route('tasks.index');
    }
}
