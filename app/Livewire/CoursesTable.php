<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CoursesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public $searchTerm = '';
    public $statusFilter = ''; // Ativo/Inativo
    public $showCreateModal = false;
    public $showUpdateModal = false;
    public $showWarning = false;
    public $warningContent = '';
    public $warningType;

    public $id, $name = '', $shift = '', $coordinator_cpf = '', $state = 1;

    public $course_id_for_action;

    // Abrir modal
    public function openModal($modal, $id = null): void
    {
        switch ($modal) {
            case 'create':
                $this->resetForm('create');
                $this->showCreateModal = true;
                break;
            case 'update':
                if ($id !== null) {
                    $this->edit($id);
                }
                break;
            case 'inactivation':
                if ($id === null) {
                    $this->showWarning('ID do curso não informado', 'Erro');
                    return;
                }
                $this->course_id_for_action = $id;
                $this->showWarning("Tem certeza que deseja inativar o curso de ID {$id}?", 'Confirmação');
                break;
        }
    }

    protected function showWarning(string $message, string $type = 'Aviso'): void
    {
        $this->warningType = $type;
        $this->warningContent = $message;
        if ($this->showWarning === false) {
            $this->showWarning = true;
        }
    }

    // Fechar modal
    public function closeModal($modal = null): void
    {
        switch ($modal) {
            case 'create':
                $this->showCreateModal = false;
                $this->resetForm('create');
                break;
            case 'update':
                $this->showUpdateModal = false;
                $this->resetForm('update');
                break;
            case 'inactivation':
                $this->showWarning = false;
                $this->reset('warningContent', 'course_id_for_action');
                break;
            default:
                $this->closeModal('create');
                $this->closeModal('update');
                $this->closeModal('inactivation');
                break;
        }
    }

    public function resetForm($field = null): void
    {
        switch ($field) {
            case 'create':
                $this->reset(['id', 'name', 'shift', 'coordinator_cpf', 'state']);
                $this->resetValidation();
                break;
            case 'update':
                $this->reset(['id', 'name', 'shift', 'coordinator_cpf', 'state','course_id_for_action']);
                $this->resetValidation();
                break;
            case 'filters':
                $this->reset('searchTerm', 'statusFilter');
                break;
            case 'inactivation':
                $this->reset('warningContent', 'course_id_for_action');
                break;
            default:
                $this->resetForm('create');
                $this->resetForm('update');
                $this->resetForm('filters');
                $this->resetForm('inactivation');
                break;
        }
    }

    public function resetError($field): void
    {
        $this->resetErrorBag($field);
    }

    public function store(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'shift' => 'required|string|in:Manhã,Tarde,Noite,Integral',
            'coordinator_cpf' => 'nullable|string|size:11',
            'state' => 'required|boolean',
        ]);

        Course::create([
            'name' => $this->name,
            'shift' => $this->shift,
            'coordinator_cpf' => $this->coordinator_cpf ?: null,
            'state' => $this->state,
        ]);

        $this->resetForm('create');

        $this->js(<<<'JS'
        window.dispatchEvent(new CustomEvent('banner-message', {
                detail: {
                    style: 'success',
                    message: 'Curso cadastrado com sucesso!'
                }
            }));
        JS);
    }

    private function edit($id): void
    {
        $course = Course::find($id);

        if (!$course) {
            $this->showWarning('Curso não encontrado.', 'Erro');
            return;
        }

        $this->id = $course->id;
        $this->name = $course->name;
        $this->shift = $course->shift;
        $this->coordinator_cpf = $course->coordinator_cpf ?? '';
        $this->state = $course->state;

        $this->showUpdateModal = true;
    }

    public function update(): void
    {
        $this->validate([
            'id' => 'required|integer|exists:courses,id',
            'name' => ['required', 'string', 'max:255', Rule::unique('courses', 'name')->ignore($this->id)],
            'shift' => 'required|string|in:Manhã,Tarde,Noite,Integral',
            'coordinator_cpf' => 'nullable|string|size:11',
            'state' => 'required|boolean',
        ]);

        $course = Course::findOrFail($this->id);

        $course->update([
            'name' => $this->name,
            'shift' => $this->shift,
            'coordinator_cpf' => $this->coordinator_cpf ?: null,
            'state' => $this->state,
        ]);

        $this->showUpdateModal = false;
        $this->resetForm('update');

        $this->js(<<<'JS'
        window.dispatchEvent(new CustomEvent('banner-message', {
                detail: {
                    style: 'success',
                    message: 'Curso Atualizado com sucesso!'
                }
            }));
        JS);
    }

    public function inactivate(): void
    {
        if (!$this->course_id_for_action) {
            $this->showWarning('ID do curso não informado.', 'Erro');
            return;
        }

        $course = Course::find($this->course_id_for_action);

        if (!$course) {
            $this->showWarning('Curso não encontrado.', 'Erro');
            return;
        }

        $course->update(['state' => 0]);

        $this->closeModal('inactivation');
    }

    public function activate($id): void
    {
        $course = Course::find($id);

        if (!$course) {
            $this->showWarning('Curso não encontrado.', 'Erro');
            return;
        }

        $course->update(['state' => 1]);
    }

    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }
    public function render()
    {
        $query = Course::query();

        if ($this->searchTerm) {
            $query->where('name', 'like', "%{$this->searchTerm}%");
        }

        if (in_array($this->statusFilter, [0, 1])) {
            $query->where('state', $this->statusFilter);
        }

        $courses = $query->paginate(10);

        return view('livewire.courses-table', compact('courses'));
    }
}
