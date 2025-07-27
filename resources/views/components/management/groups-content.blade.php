@props(['groups'])

<div>
    <template x-if="showGroupCards">
        <div class="mx-auto p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-4">
                @foreach($groups as $group)
                    <div class="flex flex-col justify-between border border-gray-300 rounded-lg shadow bg-white/80 backdrop-blur-sm transition-all duration-300 h-72 overflow-hidden hover:shadow-md">
                        {{-- Cabeçalho --}}
                        <div class="flex justify-start text-gray-800 h-[5rem] py-5 px-6 rounded-t-lg">
                            <div class="max-w-full">
                                <h2 class="text-lg font-semibold line-clamp-2 leading-tight">
                                    {{ $group['theme'] }}
                                </h2>
                            </div>
                        </div>

                        {{-- Corpo com total de membros --}}
                        <div class="flex items-center gap-1 text-sm text-gray-700 font-medium px-6 pb-2">
                            <x-lucide-users class="w-4 h-4 text-gray-500" />
                            <span>{{ count($group['students']) }} {{ Str::plural('membro', count($group['students'])) }}</span>
                        </div>
                        <div class="overflow-auto flex-1 scrollbar-custom px-6">
                            <ul class="space-y-1 text-gray-600 text-sm">
                                @foreach($group['students'] as $student)
                                    <li>{{ $student }}</li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Ações do trabalho --}}
                        <div class="min-w-full px-3 py-1">
                            <button
                                type="button"
                                class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100 transition cursor-pointer w-full"
                                x-on:click="showPaper('/papers/{{ $group['file_path'] }}')"
                            >
                                <x-lucide-file-text class="w-4 h-4 text-gray-600" />
                                <span class="text-sm text-gray-800 font-semibold">Ver trabalho</span>
                            </button>
                        </div>
                        <hr class="border-t border-gray-300 mx-3" />
                        {{-- Rodapé --}}
                        <div class="flex items-center justify-between px-3 py-2">
                        <span @class([
                            'text-xs ms-4 py-1 px-3 font-bold rounded-s-lg rounded-e-lg',
                            'bg-secondary-blue text-white' => $group['state'] === 1,
                            'bg-gray-100 text-gray-600' => $group['state'] === 0,
                        ])>
                            {{ $group['state'] === 1 ? 'Ativo' : 'Inativo' }}
                        </span>
                            <div class="flex gap-2">
                                <x-button type="button" class="min-w-[90px]">Alterar</x-button>
                                <x-danger-button type="button" class="min-w-[90px]">
                                    {{ $group['state'] ? 'Inativar' : 'Ativar' }}
                                </x-danger-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </template>
</div>
