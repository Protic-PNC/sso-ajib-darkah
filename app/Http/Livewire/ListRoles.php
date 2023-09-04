<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class ListRoles extends Component
{
    use WithPagination;
    use Actions;

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public $openModal = false;
    public $name;
    public $roleId;

    public function edit($id)
    {
        $this->openModal = true;

        $role = Role::find($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
    }

    public function save($id)
    {
        $this->validate([
            'name' => 'required'
        ]);

        $role = Role::find($id);

        if ($role) {
            $role->update([
                'name' => $this->name
            ]);

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil diubah'
            );

            $this->reset('name');
            $this->openModal = false;
        }
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
        $role = Role::find($id);

        if ($role) {
            $role->delete();

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil dihapus'
            );
        }
    }

    public function render()
    {
        $roles = Role::query();

        return view('livewire.list-roles', [
            'roles' => $roles->paginate(10)
        ])->extends('layouts.app');
    }
}
