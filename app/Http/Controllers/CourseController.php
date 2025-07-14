<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $items = [
            [
                'titulo' => 'Curso de Programação Web',
                'descricao' => 'HTML, CSS, JavaScript e frameworks modernos.',
            ],
            [
                'titulo' => 'Curso de Banco de Dados',
                'descricao' => 'Modelagem, SQL e administração com MySQL e PostgreSQL.',
            ],
            [
                'titulo' => 'Curso de Redes de Computadores',
                'descricao' => 'Conceitos, protocolos e infraestrutura de redes.',
            ],
            [
                'titulo' => 'Curso de Segurança da Informação',
                'descricao' => 'Princípios de segurança, criptografia e práticas de proteção.',
            ],
            [
                'titulo' => 'Curso de Inteligência Artificial',
                'descricao' => 'Fundamentos, aprendizado de máquina e aplicações práticas.',
            ],
            [
                'titulo' => 'Curso de Sistemas Operacionais',
                'descricao' => 'Arquitetura, processos, threads e gerenciamento de recursos.',
            ],
            [
                'titulo' => 'Curso de Desenvolvimento Mobile',
                'descricao' => 'Criação de apps com Flutter, React Native e Android Studio.',
            ],
            [
                'titulo' => 'Curso de Design de Interfaces',
                'descricao' => 'Foco em UI/UX com ferramentas como Figma e Adobe XD.',
            ],
            [
                'titulo' => 'Curso de Cloud Computing',
                'descricao' => 'AWS, Azure e fundamentos de computação em nuvem.',
            ],
        ];

        return view('courses');
    }

}
