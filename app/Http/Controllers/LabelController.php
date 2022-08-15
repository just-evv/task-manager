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
    public function __construct()
    {
        $this->authorizeResource(Label::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $labels = Label::paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(Request $request): View
    {
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
        $newLabel = new Label();
        $newLabel->fill($data);
        $newLabel->save();

        flash(__('messages.label.created'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Label $label
     * @return View
     */
    public function edit(Label $label): View
    {
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
        $data = $request->validated();
        $label->fill($data);
        $label->save();

        flash(__('messages.label.updated'))->success();
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
        if (!$label->tasks()->exists()) {
            $label->delete();
            flash(__('messages.label.deleted'))->success();
            return redirect()->route('labels.index');
        }

        flash(__('messages.label.unsuccessful'))->warning();
        return redirect()->route('labels.index');
    }
}
