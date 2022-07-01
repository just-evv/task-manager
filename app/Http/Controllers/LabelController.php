<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Models\Label;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $labels = Label::paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create(Request $request): Application|Factory|View
    {
        $this->authorize('create', Label::class);
        $label = new Label();
        return view('labels.create', compact('label'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLabelRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLabelRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $newLabel = new Label($data);
        $newLabel->save();

        flash(__('messages.label.created'));

        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Label $label
     * @return Application|Factory|View
     */
    public function edit(Label $label): Application|Factory|View
    {
        $this->authorize('edit', Label::class);
        $label = Label::findOrFail($label->id);
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLabelRequest $request
     * @param Label $label
     * @return RedirectResponse
     */
    public function update(UpdateLabelRequest $request, Label $label): RedirectResponse
    {
        $updatingLabel = Label::findOrFail($label->id);
        $data = $request->validated();

        $updatingLabel->fill($data);
        $updatingLabel->save();

        flash(__('messages.label.updated'));

        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return RedirectResponse
     */
    public function destroy(Label $label): RedirectResponse
    {
        $this->authorize('delete', Label::class);
        $deletingLabel = Label::findOrFail($label->id);
        $tasks = $deletingLabel->tasks()->get();

        if ($tasks->isEmpty()) {
            $deletingLabel->delete();
            flash(__('messages.label.deleted'));
            return redirect()->route('labels.index');
        }

        flash(__('messages.label.unsuccessful'))->warning();
        return redirect()->route('labels.index');
    }
}
