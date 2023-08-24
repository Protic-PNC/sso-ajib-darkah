<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListPermissions extends Component
{
    public function render()
    {
        return view('livewire.list-permissions')->extends('layouts.app');
    }
}
