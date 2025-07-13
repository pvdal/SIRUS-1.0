<?php

namespace App\Livewire\Users;

use App\Models\Coordinator;
use Livewire\Component;

class CoordinatorsTable extends Component
{
    public $showCreateModal = false;
    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }
    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    public $users = [];
    public function mount()
    {
        $this->users = [
            ['cpf' => '12345678900', 'name' => 'João Silva', 'email' => 'joao@example.com', 'estado' => 'SP'],
            ['cpf' => '98765432100', 'name' => 'Maria Souza', 'email' => 'maria@example.com', 'estado' => 'RJ'],
            ['cpf' => '45678912300', 'name' => 'Carlos Lima', 'email' => 'carlos@example.com', 'estado' => 'MG'],
            ['cpf' => '32165498700', 'name' => 'Ana Costa', 'email' => 'ana@example.com', 'estado' => 'BA'],
        ];
    }
    public function render()
    {
        return view('livewire.users.coordinators-table');
    }
}
