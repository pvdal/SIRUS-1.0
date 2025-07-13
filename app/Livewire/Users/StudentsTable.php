<?php

namespace App\Livewire\Users;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\Student;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Livewire\WithPagination;

class StudentsTable extends Component
{
    use WithPagination;
    public $search ='';
    public $showModal = false;
    public function open()
    {
        $this->showModal = true;
        // Valida os dados da tabela students
    }
    public function close()
    {
        $this->showModal = false;
        $this->clear(); // Reseta o formulário
    }
    public function clear()
    {
        $this->reset(['ra','name' ,'email' ,'semester', 'course_id', 'group_id']);
        $this->resetErrorBag(); // limpa erros de validação
    }

    public $name, $email;
    public $ra,$semester='',$group_id,$course_id;

    protected $paginationTheme = 'tailwind';
    public function render()
    {
        $students = Student::with('user')
            ->whereHas('user', fn ($q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->paginate(10);
        return view('livewire.users.students-table', compact('students'));
    }

    public function save(CreatesNewUsers $creator)
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
        $password = Str::random(12);

        // Cria o usuário reutilizando o controller CreateNewUser do Fortify
        $user = $creator->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => '123456789', // fixa só pra testar
            'password_confirmation' => '123456789',
            'access_level' => 1,
            'state' => 0,
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
        $this->clear();

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
    // Funções visuais para o formulário de cadastro
    public function resetError($field)
    {
        $this->resetErrorBag($field);
    }

    public function validateEmail()
    {
        $this->validateOnly('email', [
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);
    }
    public function validateRa()
    {
        $this->validateOnly('ra', [
            'ra' => 'required|integer|digits:13|unique:students,ra',
        ]);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
