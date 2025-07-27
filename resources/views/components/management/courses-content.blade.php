@props(['courses','coordinators'])

<div>
    {{-- Modal de cadastro --}}
    <x-custom-modal x-model="showCreateModal" @close="limparCampos()">
        <x-slot name="title">
            Criar novo curso
        </x-slot>

        <x-slot name="content">
            <!-- Banner de mensagem -->
            <x-custom-banner/>

            <form @submit.prevent="salvarCurso">
                <x-form-fields.course :coordinators="$coordinators"/>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" @click="salvarCurso" x-bind:disabled="saving">
                <span x-show="!saving">Salvar</span>
                <span x-show="saving">Salvando...</span>
            </x-secondary-button>
            <x-danger-button type="button" @click="showCreateModal = false; limparCampos()">
                Fechar
            </x-danger-button>
        </x-slot>
    </x-custom-modal>

    <!-- Tabela híbrida: novos cursos + cursos paginados -->
    <table class="min-w-full border border-gray-300 divide-y divide-gray-200 mt-5">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">ID</th>
            <th class="px-4 py-2 text-center text-gray-700">Nome</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden sm:table-cell">Turno</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Coordenador</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Estado</th>
            <th class="px-4 py-2 text-center text-gray-700">Ações</th>
        </tr>
        </thead>
        <tbody class="bg-white">
        <!-- Primeiro: Novos cursos adicionados via Alpine.js (aparecem no topo) -->
        <template x-for="course in newCourses" :key="'new-' + course.id">
            <tr class="hover:bg-gray-50 bg-green-50"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 transform scale-100 translate-y-0">
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell" x-text="course.id"></td>
                <td class="px-4 py-2 border text-center border-gray-300" x-text="course.name"></td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell" x-text="course.shift_pt"></td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell" x-text="course.coordinator_id || '-'"></td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell" x-text="course.state ? 'Ativo' : 'Inativo'"></td>
                <td class="px-4 py-2 border text-center border-gray-300">
                    <x-button type="button" class="min-w-[98px]">
                        Alterar
                    </x-button>
                    <x-danger-button type="button" class="min-w-[98px]" x-text="course.state ? 'Inativar' : 'Ativar'">
                    </x-danger-button>
                </td>
            </tr>
        </template>

        <!-- Depois: Cursos existentes do servidor -->
        @foreach($courses as $course)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $course->id }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">{{ $course->name }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell">{{ $course->shift_pt }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $course->coordinator->user->name ?? '-' }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $course->state ? 'Ativo' : 'Inativo' }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">
                    <x-button type="button" class="min-w-[98px]">
                        Alterar
                    </x-button>
                    <x-danger-button type="button" class="min-w-[98px]">
                        {{ $course->state ? 'Inativar' : 'Ativar' }}
                    </x-danger-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
