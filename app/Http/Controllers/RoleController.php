<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with([
            'permissions'
        ])
        ->orderBy('id', 'desc')
        ->get();
        //dd($roles->toArray());

        // Journalisation
        activity()
            ->log('roles index');
        // End journalisation
        return view('celestadmin.role.index')->with([
            'trashed' => null,
            'valeurs' => $roles,
            'infosPage' => array(
                'title' => 'Roles (Type utilisateurs)',
                'slug' => 'roles',
                'icon' => 'icofont-users-alt-1',
                'can' => '',
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('id', 'desc')
        ->get();
        $permissions = Permission::orderBy('name', 'desc')
        ->get();
        //dd($permissions->toArray());

        // Journalisation
        activity()
            ->log('roles create form');
        // End journalisation

        return view('celestadmin.role.create')->with([
            'valeurs' => $roles,
            'permissions' => $permissions,
            'infosPage' => array(
                'title' => 'Ajout de roles',
                'slug' => 'roles',
                'icon' => 'icofont-users-alt-1',
                'element' => 'Roles',
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:255|unique:roles',
        ]);
        $role = Role::create([
            'name' => request('name'),
        ]);

        $role->givePermissionTo(request('permissions'));

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // Journalisation
        activity()
            ->performedOn($role)
            ->log('show');
        // End journalisation

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role, $id)
    {
        $permissions = Permission::orderBy('name', 'desc')
        ->get();
        $role = Role::with([
            'permissions'
        ])
        ->findOrFail($id);
        //dd($type_taxonomie->toArray());

        // Journalisation
        activity()
            ->performedOn($role)
            ->log('roles edit form');
        // End journalisation
        return view('celestadmin.role.create')->with([
            'valeur' => $role,
            'permissions' => $permissions,
            'infosPage' => array(
                'title' => 'Modification "'.$role->name.'"',
                'slug' => 'roles',
                'icon' => 'icofont-users-alt-1',
                'element' => 'Roles',
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role, $id)
    {
        //dd(request('permissions'));
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);
        $role = Role::findOrFail($id);
        $role->name = request('name');
        $role->save();

        $role->syncPermissions(request('permissions'));
        //$role->givePermissionTo(request('permissions'));

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, $id)
    {
        if (request('status') == 'trashed') {
            $role = Role::onlyTrashed()
            ->find($id);
            $role->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $role = Role::findOrFail($id);
            $role->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function corbeille(Role $role)
    {
        $role = Role::onlyTrashed();
        $role->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Role $role, $id)
    {
        if (request('status') == 'trashed') {
            $role = Role::onlyTrashed()
            ->find($id);
            $role->restore();
        }
        else{
            $role = Role::onlyTrashed();
            $role->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }
}
