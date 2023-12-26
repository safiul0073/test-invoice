<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use App\Models\Variant;
use Inertia\Inertia;

class VariantController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Variant/Index', [
            'variants' => Variant::paginate(),
        ]);
    }

    public function create()
    {
        return Inertia::render(
            'Variant/Create'
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantRequest $request)
    {
        Variant::create($request->validated());

        return redirect()->route('variant.index')->with('message', 'Variant Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Variant $variant)
    {
        return Inertia::render(
            'Variant/Show'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variant $variant)
    {
        return Inertia::render(
            'Variant/Edit'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantRequest $request, Variant $variant)
    {
        $variant->update($request->validated());

        return redirect()->route('variant.index')->with('message', 'Variant Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant $variant)
    {
        return redirect()->route('variant.index')->with('message', 'Variant Delete Successfully');
    }
}
