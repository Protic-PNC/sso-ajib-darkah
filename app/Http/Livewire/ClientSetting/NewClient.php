<?php

namespace App\Http\Livewire\ClientSetting;

use Livewire\Component;
use Laravel\Passport\Client;
use WireUi\Traits\Actions;

class NewClient extends Component
{
    use Actions;

    public $openModal = false;
    public $name;
    public $callback;

    public function openModal()
    {
        $this->openModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'callback' => 'required|url',
        ]);

        $client = new Client();
        $client->name = $this->name;
        $client->redirect = $this->callback;
        $client->personal_access_client = false;
        $client->password_client = false;
        $client->revoked = false;
        $client->save();

        $this->notification()->success(
            $title = 'Berhasil',
            $description = 'Data berhasil ditambahkan'
        );

        $this->reset('name', 'callback');
        $this->emit('refresh');
        $this->openModal = false;
    }

    public function render()
    {
        return view('livewire.client-setting.new-client');
    }
}
