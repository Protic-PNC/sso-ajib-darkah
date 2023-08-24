<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListRoles extends Component
{
    public function render()
    {
        return view('livewire.list-roles')->extends('layouts.app');
    }
}
