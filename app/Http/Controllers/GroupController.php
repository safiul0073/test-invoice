<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Group/Index', [
            'groups' => Group::paginate(),
        ]);
    }

    public function create()
    {
        return Inertia::render(
            'Group/Create'
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        Group::create($request->validated());

        return redirect()->route('group.index')->with('message', 'Group Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Group $group)
    {
        return Inertia::render(
            'Group/Show'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return Inertia::render(
            'Group/Edit', [
                'group' => $group
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $group->update($request->validated());

        return redirect()->route('group.index')->with('message', 'Group Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('group.index')->with('message', 'Group Delete Successfully');
    }
}
