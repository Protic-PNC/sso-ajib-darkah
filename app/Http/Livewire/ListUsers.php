<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Branch;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class ListUsers extends Component
{
    use Actions;
    use WithPagination;

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public $userId;
    public $name;
    public $email;
    public $password;
    public $branches;
    public $roles;
    // public $permissions;
    public $branchSelected;
    public $roleSelected;
    // public $permissionSelected;

    public $openModal = false;

    public function edit($id)
    {
        $user = User::find($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->branches = Branch::get();
        $this->branchSelected = $user->branches->pluck('id')->toArray();
        $this->roles = Role::get();
        $this->roleSelected = $user->roles->pluck('id')->toArray();
        // $this->permissions = Permission::get();
        // $this->permissionSelected = $user->permissions->pluck('id')->toArray();

        $this->openModal = true;
    }

    public function save($id)
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'branchSelected' => 'required',
            'roleSelected' => 'required',
            // 'permissionSelected' => 'required',
        ]);

        $user = User::find($id);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->password) {
            $user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $user->branches()->sync($this->branchSelected);
        $user->syncRoles($this->roleSelected);
        // $user->syncPermissions($this->permissionSelected);

        $this->notification()->success(
            $title = 'Berhasil',
            $description = 'Data berhasil diubah'
        );

        $this->emit('refresh');
        $this->openModal = false;
    }

    public function confirmDelete($id)
    {
        $this->dialog()->confirm([
            'title'       => 'Kamu Yakin?',
            'description' => 'Hapus user ini?',
            'acceptLabel' => 'Ya, Hapus',
            'method'      => 'delete',
            'params'      => $id,
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil dihapus'
            );
        }
    }

    public function render()
    {
        $users = User::query();
        return view('livewire.list-users', [
            'users' => $users->paginate(10),
        ])->extends('layouts.app');
    }
}
