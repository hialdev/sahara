<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(){
        $datas = Role::with('applications')->get();
        $columns = [
            [
                'name' => 'name',
                'type' => 'text',
            ],
            [
                'name' => 'access to apps',
                'type' => 'relation',
                'rlt_type' => 'collection',
                'rlt_index' => 0,
                'rlt_name' => 'applications',
                'rlt_key' => 'title'
            ],
            [
                'name' => 'created_at',
                'type' => 'text'
            ]
        ];
        return view('crud.role.index', compact('datas', 'columns'));
    }

    public function add()
    {
        $applications = Application::all();
        return view('crud.role.add', compact('applications'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'applications' => 'nullable|array',
            'applications.*' => 'exists:applications,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $role = Role::create(
                ['name' => $request->name, 'guard_name' => 'web']
            );

            if ($role && $request->has('applications')) {
                $role->applications()->sync($request->applications);
            }else{
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan role : ',$role , $request);
            }

            return redirect()->route('role.index')
                ->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create role, error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $applications = Application::all();

        return view('crud.role.edit', compact('role', 'applications'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'applications' => 'nullable|array',
            'applications.*' => 'exists:applications,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $role = Role::findOrFail($id);
            $role->update(['name' => $request->name]);

            if ($request->has('applications')) {
                $role->applications()->sync($request->applications);
            } else {
                $role->applications()->detach();
            }

            return redirect()->route('role.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update role, error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->applications()->detach();
            $role->delete();

            return redirect()->route('role.index')
                ->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete role, error: ' . $e->getMessage());
        }
    }
}
