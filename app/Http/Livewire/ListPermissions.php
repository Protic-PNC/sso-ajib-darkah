<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\Actions;

class ListPermissions extends Component
{
    use WithPagination;
    use Actions;

    protected $listeners = [
        'refresh' => '$refresh'
    ];
    public $permissionId;

    public function render()
    {
        $permissions = Permission::query();
        return view('livewire.list-permissions', [
            'permissions' => $permissions->paginate(10)
        ])->extends('layouts.app');
    }
}
