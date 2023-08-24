<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ListUsers extends Component
{
    public function render()
    {
        return view('livewire.list-users')->extends('layouts.app');
    }
}
