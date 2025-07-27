<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function index()
    {
        $groups = [
            [
                'id' => 1,
                'theme' => 'Desenvolvimento Web com Laravel',
                'file_path' => 'teste.pdf',
                'state' => 1,
                'students' => ['Lucas Silva', 'Ana Paula', 'João Vitor'],
            ],
            [
                'id' => 2,
                'theme' => 'Modelagem e Administração de Banco de Dados',
                'file_path' => 'teste2.pdf',
                'state' => 0,
                'students' => ['Mariana Costa', 'Bruno Mendes', 'Clara Almeida'],
            ],
            [
                'id' => 3,
                'theme' => 'Fundamentos de Redes de Computadores',
                'file_path' => 'teste3.pdf',
                'state' => 1,
                'students' => ['Tiago Rocha', 'Gabriel Nunes', 'Isabela Martins'],
            ],
            [
                'id' => 4,
                'theme' => 'Segurança da Informação e Cibersegurança',
                'file_path' => 'files/cursos/seguranca-informacao_' . hash('sha256', 'seguranca.pdf') . '.pdf',
                'state' => 1,
                'students' => ['Felipe Lima', 'Juliana Torres', 'Renan Souza', 'Pedro Victor de Aquino Lima', 'Gustavo Fring'],
            ],
            [
                'id' => 5,
                'theme' => 'Introdução à Inteligência Artificial com Python',
                'file_path' => 'files/cursos/ia_' . hash('sha256', 'inteligencia-artificial.docx') . '.docx',
                'state' => 1,
                'students' => ['Aline Freitas', 'Caio Duarte', 'Luana Ribeiro'],
            ],
            [
                'id' => 6,
                'theme' => 'Sistemas Operacionais: Teoria e Prática',
                'file_path' => 'files/cursos/sistemas-operacionais_' . hash('sha256', 'so.pdf') . '.pdf',
                'state' => 1,
                'students' => ['Rafael Barros', 'Helena Lopes', 'Victor Hugo'],
            ],
            [
                'id' => 7,
                'theme' => 'Desenvolvimento de Aplicativos Mobile com Flutter',
                'file_path' => 'files/cursos/dev-mobile_' . hash('sha256', 'mobile.docx') . '.docx',
                'state' => 0,
                'students' => ['Pedro Henrique', 'Camila Rocha', 'Diego Monteiro'],
            ],
            [
                'id' => 8,
                'theme' => 'Design de Interfaces e Experiência do Usuário (UI/UX)',
                'file_path' => 'files/cursos/design-interfaces_' . hash('sha256', 'uiux.pdf') . '.pdf',
                'state' => 1,
                'students' => ['Beatriz Castro', 'Daniel Tavares', 'Larissa Lima'],
            ],
            [
                'id' => 9,
                'theme' => 'Computação em Nuvem com AWS e Docker',
                'file_path' => 'files/cursos/cloud-computing_' . hash('sha256', 'cloud.docx') . '.docx',
                'state' => 0,
                'students' => ['Matheus Oliveira', 'Sofia Mendes', 'Eduardo Ferreira'],
            ],
            [
                'id' => 10,
                'theme' => 'Machine Learning com Scikit-Learn',
                'file_path' => 'files/cursos/machine-learning_' . hash('sha256', 'ml.docx') . '.docx',
                'state' => 1,
                'students' => ['Fernanda Lima', 'Gustavo Carvalho', 'Lucas Pereira'],
            ],
            [
                'id' => 11,
                'theme' => 'DevOps e Integração Contínua com GitHub Actions',
                'file_path' => 'files/cursos/devops_' . hash('sha256', 'devops.pdf') . '.pdf',
                'state' => 1,
                'students' => ['Amanda Souza', 'Rodrigo Alves', 'Julio Cesar'],
            ],
            [
                'id' => 12,
                'theme' => 'Arquitetura de Software e Padrões de Projeto',
                'file_path' => 'files/cursos/arquitetura-software_' . hash('sha256', 'arquitetura.docx') . '.docx',
                'state' => 0,
                'students' => ['Vanessa Martins', 'Henrique Borges', 'Tatiane Silva'],
            ],
        ];

        return view('management.groups',compact('groups'));
    }

    public function showPaper($filename)
    {
        // Evita acesso fora da pasta
        if (str_contains($filename, '..')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists("papers/{$filename}")) {
            abort(404);
        }

        return Storage::disk('public')->response("papers/{$filename}", null, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'theme' => 'required|string|max:255|unique:groups',
            'file_path' => 'nullable|document|mimes:docx,pdf|max:5120',
        ]);
    }
}
