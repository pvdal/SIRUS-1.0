<?php

namespace App\Livewire\Users;

use Livewire\Component;

class ProfessorsTable extends Component
{
    public $showModal = false;
    public function open()
    {
        $this->showModal = true;
    }
    public function close()
    {
        $this->showModal = false;
    }
    public $users = [];
    public function mount() {
        $this->users = [
            ['ra' => 1254659857458, 'name' => 'João Silva', 'email' => 'joao@example.com', 'semestre' => '3', 'grupo' => 1, 'curso' => 'Gestão de Tecnologia da Informação', 'estado' => 1],
            ['ra' => 1254659858458, 'name' => 'Maria Souza', 'email' => 'maria@example.com', 'semestre' => '3', 'grupo' => 1, 'curso' => 'Gestão de Tecnologia da Informação', 'estado' => 1],
            ['ra' => 1250099857458, 'name' => 'Carlos Lima', 'email' => 'carlos@example.com', 'semestre' => '3', 'grupo' => 1, 'curso' => 'Gestão de Tecnologia da Informação', 'estado' => 1],
            ['ra' => 1250099117458, 'name' => 'Ana Costa', 'email' => 'ana@example.com', 'semestre' => '3', 'grupo' => 1, 'curso' => 'Gestão de Tecnologia da Informação', 'estado' => 1],
        ];

    }
    public function render()
    {
        return view('livewire.users.professors-table');
    }
}
