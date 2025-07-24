@props(['cursos'])

<div>
    <!-- Botão para abrir modal -->
    <div class="flex flex-wrap pt-4 ps-2 pe-2 sm:ps-8 sm:me-8">
        <x-button
            @click="showModal = true; $el.blur()"
            class="py-3"
        >
            Cadastrar curso
        </x-button>
    </div>

    <!-- Modal de cadastro -->
    <x-custom-modal x-model="showModal" @close="limparCampos()">
        <x-slot name="title">
            Criar novo curso
        </x-slot>

        <x-slot name="content">
            <!-- Banner de mensagem -->
            <div x-show="showBanner" x-transition
                 class="flex top-4 right-4 px-4 py-2 rounded shadow text-white z-50 mb-4"
                 x-bind:class="{
                     'bg-green-600': style === 'success',
                     'bg-red-600': style === 'danger',
                     'bg-yellow-500': style === 'warning'
                 }">
                <template x-if="style === 'success'">
                    <x-lucide-check-circle class="w-4 h-4 mr-2 mt-[4px]"/>
                </template>
                <template x-if="style === 'danger'">
                    <x-lucide-x-circle class="w-4 h-4 mr-2 mt-[4px]"/>
                </template>
                <template x-if="style === 'warning'">
                    <x-lucide-alert-triangle class="w-4 h-4 mr-2 mt-[4px]"/>
                </template>
                <span x-text="message"></span>
            </div>

            <form @submit.prevent="salvarCurso">
                <div class="mt-4">
                    <x-label for="name" value="Nome do Curso"/>
                    <x-input id="name" type="text" autocomplete="name" class="w-full"
                             placeholder="Nome do curso" x-model="name"/>
                    <template x-if="errors.name">
                        <p class="text-red-600 text-sm" x-text="errors.name[0]"></p>
                    </template>
                </div>

                <div class="mt-4">
                    <x-label for="shift" value="Turno"/>
                    <select id="shift" class="w-full rounded border-gray-300" x-model="shift">
                        <option value="" disabled selected>Selecione o turno</option>
                        <option value="Manhã">Matutino</option>
                        <option value="Tarde">Vespertino</option>
                        <option value="Noite">Noturno</option>
                    </select>
                    <template x-if="errors.shift">
                        <p class="text-red-600 text-sm" x-text="errors.shift[0]"></p>
                    </template>
                </div>

                <div class="mt-4">
                    <x-label for="coordinator_cpf" value="CPF do Coordenador (opcional)"/>
                    <x-input id="coordinator_cpf" type="text" class="w-full"
                             placeholder="CPF do coordenador" x-model="coordinator_cpf"/>
                    <template x-if="errors.coordinator_cpf">
                        <p class="text-red-600 text-sm" x-text="errors.coordinator_cpf[0]"></p>
                    </template>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-button type="button" @click="salvarCurso" x-bind:disabled="saving">
                <span x-show="!saving">Salvar</span>
                <span x-show="saving">Salvando...</span>
            </x-button>
            <x-danger-button type="button" @click="showModal = false; limparCampos()">
                Fechar
            </x-danger-button>
        </x-slot>
    </x-custom-modal>

    <!-- ✅ Tabela híbrida: novos cursos + cursos paginados -->
    <table class="min-w-full border border-gray-300 divide-y divide-gray-200 mt-5">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">ID</th>
            <th class="px-4 py-2 text-center text-gray-700">Nome</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden sm:table-cell">Turno</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">CPF Coordenador</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Estado</th>
            <th class="px-4 py-2 text-center text-gray-700">Ações</th>
        </tr>
        </thead>
        <tbody class="bg-white">
        <!-- ✅ Primeiro: Novos cursos adicionados via Alpine.js (aparecem no topo) -->
        <template x-for="curso in novosCursos" :key="'novo-' + curso.id">
            <tr class="hover:bg-gray-50 bg-green-50"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 transform scale-100 translate-y-0">
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell" x-text="curso.id"></td>
                <td class="px-4 py-2 border text-center border-gray-300" x-text="curso.name"></td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell" x-text="curso.shift"></td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell" x-text="curso.coordinator_cpf || '-'"></td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell" x-text="curso.state ? 'Ativo' : 'Inativo'"></td>
                <td class="px-4 py-2 border text-center border-gray-300">
                    <x-button type="button" class="min-w-[98px]">
                        Alterar
                    </x-button>
                    <x-danger-button type="button" class="min-w-[98px]" x-text="curso.state ? 'Inativar' : 'Ativar'">
                    </x-danger-button>
                </td>
            </tr>
        </template>

        <!-- ✅ Depois: Cursos existentes do servidor -->
        @foreach($cursos as $curso)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $curso->id }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">{{ $curso->name }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell">{{ $curso->shift }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $curso->coordinator_cpf ?? '-' }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $curso->state ? 'Ativo' : 'Inativo' }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">
                    <x-button type="button" class="min-w-[98px]">
                        Alterar
                    </x-button>
                    <x-danger-button type="button" class="min-w-[98px]">
                        {{ $curso->state ? 'Inativar' : 'Ativar' }}
                    </x-danger-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
