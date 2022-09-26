<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class);
    }
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
     * @throws AuthorizationException
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
        $messages = ['unique' => __('validation.status.unique')];
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses'
        ], $messages);

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();

        flash(__('messages.status.created'))->success();
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
        return view('task_statuses.edit', compact('taskStatus'));
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
        $messages = ['unique' => __('validation.status.unique')];
        $data = $this->validate($request, [
            'name' => ['required', Rule::unique('task_statuses')->ignore($taskStatus)]
        ], $messages);

        $taskStatus->fill($data);
        $taskStatus->save();

        flash(__('messages.status.updated'))->success();
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
        if (!$taskStatus->tasks()->exists()) {
            $taskStatus->delete();
            flash(__('messages.status.deleted'))->success();
            return redirect()->route('task_statuses.index');
        }

         flash(__('messages.status.unsuccessful'))->warning();
         return redirect()->route('task_statuses.index');
    }
}
