<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use WireUi\Traits\Actions;
use Spatie\Permission\Models\Role;

class NewRole extends Component
{
    use Actions;

    public $openModal = false;
    public $name;

    public function openModal()
    {
        $this->openModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required'
        ]);

        $role = Role::create([
            'name' => $this->name
        ]);

        if ($role) {
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil ditambahkan'
            );

            $this->reset('name');
            $this->emit('refresh');
            $this->openModal = false;
        }
    }

    public function render()
    {
        return view('livewire.role.new-role');
    }
}
