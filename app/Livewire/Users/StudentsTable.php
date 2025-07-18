<?php

namespace App\Livewire\Users;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\Student;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class StudentsTable extends Component
{
    use WithPagination;
    //#region Propriedades públicas
    // Tema dos botões de paginação
    protected $paginationTheme = 'tailwind';
    public $searchTerm ='';
    public $statusFilter = 1;
    public $registerPeriod = null;
    public $showCreateModal = false;
    public $showUpdateModal = false;
    public $showInactivationConfirmation = false;

    public $name, $email;
    public $ra,$semester='',$group_id,$course_id;
    public $user_id;
    //#endregion
    // Abrir modal
    public function openModal($modal,$ra = null)
    {
        switch ($modal)
        {
            case 'create':
                $this->resetForm('create');
                $this->showCreateModal = true;
                break;
            case 'update':
                if($ra !== null)
                {
                    $this->edit($ra);
                }
                break;
            case 'inactivation':
                $this->showInactivationConfirmation = true;
                break;
        }
    }
    // Fechar modal
    public function closeModal($modal=null)
    {
        switch ($modal)
        {
            case 'create':
                $this->showCreateModal = false;
                $this->resetForm('create');
                break;
            case 'update':
                $this->showUpdateModal = false;
                $this->resetForm('update');
                break;
            case 'inactivation':
                $this->showInactivationConfirmation = false;
                break;

            default:
                // Fecha tudo se nenhum $modal for passado
                $this->closeModal('create');
                $this->closeModal('update');
                $this->closeModal('inactivation');
                break;
        }
    }
    // Limpa campos ou parâmetros de pesquisa
    public function resetForm($field=null)
    {
        switch ($field)
        {
            case 'create':
                $this->reset(['ra','name' ,'email' ,'semester', 'course_id', 'group_id']);
                $this->resetErrorBag(); // limpa erros de validação
                break;
            case 'update':
                $this->reset(['ra','name' ,'email' ,'semester', 'course_id', 'group_id','user_id']);
                $this->resetErrorBag(); // limpa erros de validação
                break;
            case 'filters':
                $this->reset('searchTerm','statusFilter','registerPeriod');
                break;

            default:
                $this->resetForm('create');
                $this->resetForm('create');
                $this->resetForm('filters');
                break;
        }
    }

    //#region Validações dinâmicas. Funções visuais e de segurança para o formulário de cadastro e atualização
    public function resetError($field)
    {
        $this->resetErrorBag($field);
    }
    public function validateEmail($modal)
    {
        switch ($modal)
        {
            case 'create':
                $this->validateOnly('email', [
                    'email' => 'required|email:rfc,dns|unique:users,email',
                ]);
                break;
            case 'update':
                $this->validateOnly('email', [
                    'email' => [
                        'required',
                        'email:rfc,dns',
                        Rule::unique('users', 'email')->ignore($this->user_id),
                    ],
                ]);
                break;
        }
    }
    public function validateRa()
    {
        $this->validateOnly('ra', [
            'ra' => 'required|integer|digits:13|unique:students,ra',
        ]);
    }
    //#endregion

    //#region Lifecycle / Busca
    public function updatingSearch()
    {
        $this->resetPage();
    }
    //#endregion

    //#region CRUD -> store, render (read), edit + update, inactive
    // Salvamento
    public function store(CreatesNewUsers $creator)
    {
        // Valida os dados da tabela students
        $this->validate([
            'ra' => 'required|integer|digits:13|unique:students',
            'name' => 'required',
            'email' => 'required',
            'semester' => 'required|integer|between:1,10',
            'course_id' => 'nullable|integer|exists:courses,id',
            'group_id' => 'nullable|integer|exists:groups,id',
        ]);

        // Gera senha aleatória
        // $password = Str::random(12);

        // Cria o usuário reutilizando o controller CreateNewUser do Fortify
        // Não precisa usar Hash aqui na senha, o CreateNewUser já faz isso
        $user = $creator->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'access_level' => 1,
            'state' => 1,
        ]);
        // Cria o aluno na tabela específica
        Student::create([
            'ra' => $this->ra,
            'user_id' => $user->id,
            'semester' => $this->semester,
            'course_id' => $this->course_id,
            'group_id' => $this->group_id,
        ]);

        // Envia o link de definição de senha para o e-mail
        // Password::broker()->sendResetLink(['email' => $user->email,]);

        // Reseta o formulário
        $this->resetForm('create');

        //session()->flash('success', 'Estudante cadastrado com sucesso!');
        $this->js(<<<'JS'
        window.dispatchEvent(new CustomEvent('banner-message', {
                detail: {
                    style: 'success',
                    message: 'Estudante cadastrado com sucesso!'
                }
            }));
        JS);
    }
    // Atualização
    private function edit($ra)
    {
        $student = Student::with('user')->findOrFail($ra);

        $this->user_id = $student->user->id;

        $this->ra = $student->ra;
        $this->name = $student->user->name;
        $this->email = $student->user->email;
        $this->semester = $student->semester;
        $this->course_id = $student->course_id;
        $this->group_id = $student->group_id;
        $this->showUpdateModal = true;
    }
    public function update()
    {
        // Valida e atualiza dados do usuário e estudante
    }
    public function inactivate()
    {
        // Define state = 0 para user relacionado
    }
    // Renderiza o componente livewire
    public function render()
    {
        $students = Student::with('user')
            ->whereHas('user', fn ($q) =>
            $q->where('name', 'like', "%{$this->searchTerm}%")
            )
            ->paginate(10);
        return view('livewire.users.students-table', compact('students'));
    }
    //#endregion
}
