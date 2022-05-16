<?php

namespace App\Http\Controllers;

use App\Models\Label;
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
     */
    public function create(): Application|Factory|View
    {
        $label = new Label();
        return view('labels.create', compact('label'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:labels',
            'description' => 'nullable|max:255'
        ]);

        $newLabel = new Label($data);
        $newLabel->save();

        flash(__('messages.created', ['name' => 'label']));

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
        $label = Label::findOrFail($label->id);
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Label $labe
     * @return RedirectResponse
     */
    public function update(Request $request, Label $label): RedirectResponse
    {
        $updatingLabel = Label::findOrFail($label->id);
        $data = $this->validate($request, [
            'name' => 'required|unique:labels,name,' . $updatingLabel->id,
            'description' => 'nullable|max:255'
        ]);

        $updatingLabel->fill($data);
        $updatingLabel->save();

        flash(__('messages.updated', ['name' => 'label']));

        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return Response
     */
    public function destroy(Label $label)
    {
        //
    }
}
