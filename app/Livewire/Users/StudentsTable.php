<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\Student;
use App\Models\User;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class StudentsTable extends Component
{
    use WithPagination;
    //#region Propriedades públicas
    // Tema dos botões de paginação
    protected $paginationTheme = 'tailwind';

    public $searchTerm ='';
    public $statusFilter = 1;
    public $registerPeriod = '';
    public $showCreateModal = false;
    public $showUpdateModal = false;
    public $showWarning = false; // Modal de aviso
    public $warningContent=''; // Conteúdo do modal de aviso
    public $warningType; // valores possíveis: 'erro', 'confirmacao', etc.

    public $name='', $email='';
    public $ra='',$semester='',$group_id='',$course_id='';
    /*
    Variáveis de segurança
        user_id armazena o id de usuário do aluno ao clicar em alterar, e garante que a função 'update' trabalhe em cima do ra que aparece inicialmente no modal,
        em vez de qualquer outro que o usuário possa ter incluído apos a abertura do modal.
        user_ra armazena o ra do aluno relacionado a linha do botão de inativação clicado na tabela, e quando o usuário confirma a inativação, a função inactivate
        trabalha em cima do user_ra, dessa forma, nessa janela de confirmação, o botão de confirmação não precisa passar nenhum parâmetro, isso evita o usuário
        altere o parâmetro e inative um usuário diferente do que deveria.
    */
    public $user_id, $user_ra;
    //#endregion

    //#region Controle de modais
    // Abrir modal
    public function openModal($modal,$ra = null): void
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
                if($ra == null)
                {
                    $this->showWarning('RA do aluno não informado','Erro');
                    return;
                }
                $this->user_ra = $ra;
                $this->showWarning("Tem certeza que deseja inativar o aluno portador do RA {$this->user_ra}?",'Confirmação');
                break;
        }
    }
    // Abrir modal de confirmação, está separado porque tem um comportamento específico
    protected function showWarning(string $message, string $type = 'Aviso'): void
    {
        $this->warningType = $type;
        $this->warningContent = $message;
        if($this->showWarning === false) {
            $this->showWarning = true;
        }
    }
    // Fechar modal
    public function closeModal($modal = null): void
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
                $this->showWarning = false;
                $this->resetForm('inactivation');
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
    public function resetForm($field = null): void
    {
        switch ($field)
        {
            case 'create':
                $this->reset(['ra','name' ,'email' ,'semester', 'course_id', 'group_id']);
                $this->resetValidation(); // limpa erros de validação
                break;
            case 'update':
                $this->reset(['ra','name' ,'email' ,'semester', 'course_id', 'group_id','user_id']);
                $this->resetValidation(); // limpa erros de validação
                break;
            case 'filters':
                $this->reset('searchTerm','statusFilter','registerPeriod');
                break;
            case 'inactivation':
                $this->reset('warningContent','user_ra');
                break;
            default:
                $this->resetForm('create');
                $this->resetForm('update');
                $this->resetForm('filters');
                $this->resetForm('inactivation');
                break;
        }
    }
    //#endregion

    //#region Validações dinâmicas. Funções visuais e de segurança para o formulário de cadastro e atualização
    public function resetError($field): void
    {
        $this->resetErrorBag($field);
    }
    public function validateEmail($modal): void
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
    public function validateRa(): void
    {
        $this->validateOnly('ra', [
            'ra' => 'required|integer|digits:13|unique:students,ra',
        ]);
    }
    //#endregion

    //#region Lifecycle / Busca
    public function updatingSearchTerm(): void
    {
        $this->resetPage();
    }
    //#endregion

    //#region CRUD -> store, render (read), edit + update, inactive + active
    // Salvamento
    public function store(CreatesNewUsers $creator): void
    {
        // Valida os dados da tabela students
        $this->validate([
            'ra' => 'required|integer|digits:13|unique:students',
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
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
            'course_id' => $this->course_id ?: null,
            'group_id' => $this->group_id ?: null,
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
    private function edit($ra): void
    {
        $student = Student::with('user')->find($ra);

        if (!$student || !$student->user) {
            $this->showWarning('Aluno ou usuário associado não encontrado.', 'Erro');
            return;
        }

        $this->user_id = $student->user->id;

        $this->ra = $student->ra;
        $this->name = $student->user->name;
        $this->email = $student->user->email;
        $this->semester = $student->semester;
        $this->course_id = $student->course_id ?? '';
        $this->group_id = $student->group_id ?? '';

        $this->showUpdateModal = true;
    }
    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'semester' => 'required|integer|between:1,10',
            'course_id' => 'nullable|integer|exists:courses,id',
            'group_id' => 'nullable|integer|exists:groups,id',
        ]);

        // Atualiza os dados do usuário
        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Busca o aluno relacionado ao user_id
        $student = Student::where('user_id', $this->user_id)->firstOrFail();
        $student->update([
            'semester' => $this->semester,
            'course_id' => $this->course_id ?: null,
            'group_id' => $this->group_id ?: null,
        ]);

        // Mensagem de sucesso, caso haja
        $this->js(<<<'JS'
        window.dispatchEvent(new CustomEvent('banner-message', {
                detail: {
                    style: 'success',
                    message: 'Dados atualizados com sucesso!'
                }
            }));
        JS);
    }
    public function inactivate(): void
    {
        $student = Student::with('user')->find($this->user_ra);

        if (!$student || !$student->user) {
            $this->showWarning('Aluno ou usuário associado não encontrado.', 'Erro');
            return;
        }

        $student->user->update([
            'state' => 0,
        ]);

        // $this->showWarning('Usuário inativado.', 'Sucesso'); // Caso queira que o modal exiba sucesso
        $this->closeModal('inactivation'); // Caso queira fechar sem exibir mensagem de sucesso
    }
    public function activate($ra): void
    {
        $student = Student::with('user')->find($ra);

        if (!$student || !$student->user) {
            $this->showWarning('Aluno ou usuário associado não encontrado.', 'Erro');
            return;
        }

        $student->user->update([
            'state' => 1,
        ]);

        // $this->showWarning('Usuário Ativado.', 'Sucesso'); // Caso queira exibir mensagem de sucesso
    }
    // Renderiza o componente livewire
    public function render(): View
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
