<?php

namespace App\Http\Livewire;

use Laravel\Passport\Client;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class ClientSetting extends Component
{
    use WithPagination;
    use Actions;
    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public $openModal = false;
    public $name;
    public $callback;
    public $clientId;
    public $revokeToken;

    public function edit($id)
    {
        $this->openModal = true;

        $client = Client::find($id);
        $this->clientId = $client->id;
        $this->name = $client->name;
        $this->callback = $client->redirect;
        $this->revokeToken = $client->revoked;
    }

    public function save($id)
    {
        $this->validate([
            'name' => 'required',
            'callback' => 'required|url',
        ]);

        $client = Client::find($id);

        if ($client) {
            $client->update([
                'name' => $this->name,
                'redirect' => $this->callback,
            ]);

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil diubah'
            );

            $this->reset('name', 'callback');
            $this->emit('refresh');
            $this->openModal = false;
        }
    }

    public function updatedRevokeToken()
    {
        $client = Client::find($this->clientId);

        if ($client) {
            $client->update([
                'revoked' => $this->revokeToken,
            ]);

            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil diubah'
            );

            $this->emit('refresh');
            $this->openModal = false;
        }
    }

    public function confirmDelete($id)
    {
        $this->dialog()->confirm([
            'title'       => 'Kamu Yakin?',
            'description' => 'Hapus data ini?',
            'acceptLabel' => 'Ya, Hapus',
            'method'      => 'delete',
            'params'      => $id,
        ]);
    }

    public function delete($id)
    {
        $client = Client::find($id);

        if ($client) {
            $client->delete();
            $this->notification()->success(
                $title = 'Berhasil',
                $description = 'Data berhasil dihapus'
            );
        }
    }

    public function render()
    {
        $clients = Client::query();

        return view('livewire.client-setting', [
            'clients' => $clients->paginate(10),
        ])->extends('layouts.app');
    }
}
