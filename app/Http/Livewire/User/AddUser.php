<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\Actions;

class AddUser extends Component
{
    use Actions;
    public $openModal = false;
    public $name;
    public $email;
    public $password = 12345678;
    public $branches;
    public $roles;
    // public $permissions;
    public $branchSelected;
    public $roleSelected;
    // public $permissionSelected;

    public function openModal()
    {
        $this->openModal = true;

        $this->branches = Branch::get();
        $this->roles = Role::get();
        // $this->permissions = Permission::all();
    }

    public function save()
    {
        try{
            $this->validate([
                'name' => 'required',
                'email' => 'required|unique:users',
                'branchSelected' => 'required',
                'roleSelected' => 'required',
                // 'permissionSelected' => 'required',
            ]);

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            foreach ($this->branchSelected as $branch) {
                $user->branches()->attach($branch);
            }

            foreach ($this->roleSelected as $role) {
                $user->assignRole($role);
            }

            // foreach ($this->permissionSelected as $permission) {
            //     $user->givePermissionTo($permission);
            // }

            $this->reset(['name', 'email', 'branchSelected', 'roleSelected']);
            $this->emit('refresh');
            $this->openModal = false;

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'User berhasil dibuat'
            );
        }catch(\Exception $e){
            logger()->error($e->getMessage());
            $this->notification()->error(
                $title = 'Gagal',
                $description = 'User gagal dibuat'
            );
        }

    }

    public function render()
    {
        return view('livewire.user.add-user');
    }
}
