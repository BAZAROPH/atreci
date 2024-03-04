<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$role = Role::create(['name' => 'membre']);
        $permissions = Permission::orderBy('id', 'desc')
        ->get();

        //$permissions = Permission::find(5);
        //$roles->givePermissionTo($permissions);
        //$permission->assignRole($role);
        //$permission = auth()->user()->permissions;
        //$users_without_any_roles = User::doesntHave('roles')->get();
        //dd($users_without_any_roles->toArray());


        // Journalisation
        activity()
            ->log('permissions index');
        // End journalisation

        return view('celestadmin.permission.index')->with([
            'trashed' => null,
            'valeurs' => $permissions,
            'infosPage' => array(
                'title' => 'Permissions',
                'slug' => 'permissions',
                'icon' => 'icofont-lock',
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
        $permissions = Permission::orderBy('id', 'desc')
        ->get();
        //dd($permissions->toArray());

        // Journalisation

        activity()
            ->log('permissions create form');
        // End journalisation

        return view('celestadmin.permission.create')->with([
            'valeurs' => $permissions,
            'infosPage' => array(
                'title' => 'Ajout de permissions',
                'slug' => 'permissions',
                'icon' => 'icofont-lock',
                'element' => 'Permissions',
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
            'name' => 'required|max:255|unique:permissions',
        ]);

        Permission::create([
            'name' => request('name'),
        ]);

        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        // Journalisation
        activity()
            ->performedOn($permission)
            ->log('show');
        // End journalisation
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = Permission::orderBy('id', 'desc')
        ->get();
        $permission = Permission::find($id);
        //dd($type_taxonomie->toArray());

        // Journalisation
        activity()
            ->performedOn($permission)
            ->log('permissions edit form');
        // End journalisation

        return view('celestadmin.permission.create')->with([
            'valeur' => $permission,
            'valeurs' => $permissions,
            'infosPage' => array(
                'title' => 'Modification "'.$permission->name.'"',
                'slug' => 'permissions',
                'icon' => 'icofont-lock',
                'element' => 'Permissions',
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);
        $permission = Permission::findOrFail($id);
        $permission->name = request('name');
        $permission->save();

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission, $id)
    {
        if (request('status') == 'trashed') {
            $permission = Permission::onlyTrashed()
            ->find($id);
            $permission->forceDelete();
            flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        }
        else {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            flash()->overlay('Mise en corbeille effectuée avec succès', 'Message')->success();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function corbeille(Permission $permission)
    {
        $permission = Permission::onlyTrashed();
        $permission->forceDelete();

        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function restaurer(Permission $permission, $id)
    {
        if (request('status') == 'trashed') {
            $permission = Permission::onlyTrashed()
            ->find($id);
            $permission->restore();
        }
        else{
            $permission = Permission::onlyTrashed();
            $permission->restore();
        }
        flash()->overlay('Restauration effectuée avec succès', 'Message')->success();
        return back();
    }
}
