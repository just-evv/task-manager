<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $statuses = TaskStatus::paginate();
        return view('task_statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses'
        ]);

        $newStatus = new TaskStatus($data);
        $newStatus->save();

        flash(__('messages.created', ['name' => 'task status']));

        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TaskStatus $taskStatus
     * @return Application|Factory|View
     */
    public function edit(TaskStatus $taskStatus): View|Factory|Application
    {
        $status = TaskStatus::findOrFail($taskStatus->id);
        return view('task_statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TaskStatus $taskStatus
     * @return RedirectResponse
     */
    public function update(Request $request, TaskStatus $taskStatus): RedirectResponse
    {
        $status = TaskStatus::findOrFail($taskStatus->id);
        $data = $this->validate($request, [

            'name' => 'required|unique:task_statuses,name,' . $status->id,
        ]);

        $status->fill($data);
        $status->save();

        flash(__('messages.updated', ['name' => 'task status']));

        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TaskStatus $taskStatus
     * @return RedirectResponse
     */
    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        $status = TaskStatus::find($taskStatus->id);
        $tasks = $status->tasks()->get();

        if ($tasks->isEmpty()) {
            $status->delete();
            flash(__('messages.deleted', ['name' => 'task status']));
            return redirect()->route('task_statuses.index');
        }

         flash(__('messages.unsuccessful', ['name' => 'task status']))->warning();
         return redirect()->route('task_statuses.index');
    }
}
