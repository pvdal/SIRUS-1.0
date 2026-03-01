<div>
    @can('manage-events')
        {{-- Modal de cadastro --}}
        <x-custom-modal x-model="showCreateModal">
            <x-slot name="title">
                <div class="flex flex-wrap items-center justify-start gap-3">
                    <template x-if="!edit">
                        <span class="mr-auto">Cadastrar nova banca</span>
                    </template>
                    <template x-if="edit">
                        <span class="mr-auto">Atualizar os dados da banca</span>
                    </template>

                    <template x-if="edit">
                        <div>
                            <template x-if="belongsTo && !evaluatedByUser">
                                <x-secondary-button x-on:click="openEvaluationForm()">Avaliar</x-secondary-button>
                            </template>
                            <template x-if="!belongsTo || evaluatedByUser">
                                <x-secondary-button x-on:click="openEvaluationForm()">Avaliação</x-secondary-button>
                            </template>
                        </div>
                    </template>
                </div>
            </x-slot>

            <x-slot name="content">
                {{-- Banner de mensagem --}}
                <x-custom-banner/>
                {{-- Formulário --}}
                <x-form-fields.committee/>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button type="button" x-bind:disabled="saving" class="min-w-[110px]"
                    x-on:click="
                        saveCommittee();
                        $el.blur();
                    "
                >
                    <span x-show="!saving">Salvar</span>
                    <span x-show="saving">Salvando...</span>
                </x-secondary-button>
                <x-danger-button type="button" class="min-w-[110px]"
                                 x-on:click="
                    showCreateModal = false;
                    clearFields('store');
                "
                >
                    Fechar
                </x-danger-button>
            </x-slot>
        </x-custom-modal>


        {{-- Component modal para avisos --}}
        <x-warning-modal x-model="showWarningModal" @close="showWarningModal = false; clearFields('warning');" :maxWidth="'lg'" :warningType="'warningType'">
            <x-slot name="title">
                <template x-if="warningType">
                    <span x-text="warningType" class="font-semibold"></span>
                </template>
            </x-slot>

            <x-slot name="content">
                <template x-if="warningContent">
                    <p x-text="warningContent"></p>
                </template>
            </x-slot>

            <x-slot name="footer">
                <template x-if="warningType === 'Confirmação'">
                    <x-danger-button type="button"
                        x-on:click="
                            toggleStatus();
                            $el.blur();
                        "
                        x-text="warningAction"
                    >
                    </x-danger-button>
                </template>
                <x-secondary-button type="button" @click="showWarningModal = false; clearFields('warning');" class="ms-4">
                    Voltar
                </x-secondary-button>
            </x-slot>
        </x-warning-modal>
    @endcan
    {{-- View dos cards --}}
    <div x-show="!isEmpty && !loading" class="mx-auto p-6">
        <div x-show="committees.length > 0" class="max-h-[60px] max-w-sm md:max-w-full flex flex-row justify-start mb-2 mx-auto space-x-1">
            <button class="px-3 whitespace-nowrap border rounded-md text-gray-700 dark:text-gray-100 text-sm transition duration-150 ease-in-out"
                x-on:click="
                    $el.blur();
                    setAllCardType('committee');
                "
                    :class="!hasGroupCard() ? 'cursor-default pointer-events-none bg-gray-200 dark:bg-gray-700 font-semibold' : ''"
            >
                &lsaquo; Bancas
            </button>
            <button class="px-3 whitespace-nowrap border rounded-md text-gray-700 dark:text-gray-100 text-sm transition duration-150 ease-in-out"
                x-on:click="
                    $el.blur();
                    setAllCardType('group');
                "
                    :class="!hasCommitteeCard() ? 'cursor-default pointer-events-none bg-gray-200 dark:bg-gray-700 font-semibold' : ''"
            >
                Grupos &rsaquo;
            </button>
        </div>
        <x-card.grid
            :items="'committees'"
            :new-items="'newCommittees'"
            :item-key="'id'"
        >
            <x-card.layout>
                {{-- Card da banca --}}
                <x-card.content
                    x-show="getCardType(item.id) === 'committee'"
                    :listMeta="['count' => 'members', 'icon' => 'users', 'sinTitle' => 'Membro', 'pluTitle' => 'Membros']"
                >
                    <x-slot name="header">
                        <span x-text="item.id" class="text-sm text-gray-600 dark:text-gray-300 me-3 transition duration-150 ease-in-out"></span>
                        @can('evaluate')
                            <span
                                x-text="'CRIADOR: ' + item.coordinator_name"
                                class="whitespace-nowrap overflow-hidden text-ellipsis text-xs text-gray-700 dark:text-gray-200 font-medium uppercase
                                    transition duration-150 ease-in-out"
                            ></span>
                        @endcan
                        <button class="px-3 my-1 whitespace-nowrap ms-auto bg-secondary-blue rounded-md text-white dark:text-gray-200 text-sm"
                            x-on:click="
                                $el.blur();
                                setCardType(item.id,'group');
                            "
                        >
                            Grupo &raquo;
                        </button>
                    </x-slot>

                    <x-slot name="title">
                        <h3 class="text-lg font-semibold line-clamp-2 leading-snug" x-text="item.name"></h3>
                    </x-slot>

                    <x-slot name="list">
                        <template x-for="member in item.members" :key="member.user_id">
                            <li
                                x-text="`${member.name}: ${member.member_type.name}`"
                                :class="member.state == 0 ? 'line-through text-gray-400' : ''"
                            ></li>
                        </template>
                    </x-slot>
                    @can('manage-events')
                        <x-slot name="state">
                            <span
                                class="inline-flex text-xs py-1 ms-4 px-3 font-bold rounded-s-lg rounded-e-lg transition duration-150 ease-in-out"
                                :class="item?.state === 1
                                ? 'bg-secondary-blue text-white dark:text-gray-200'
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200'"
                                x-text="item?.state === 1 ? 'Ativo' : 'Inativo'">
                            </span>
                        </x-slot>
                    @endcan

                    <x-slot name="actions">
                        @can('manage-events')
                            <template x-if="item.state">
                                <x-button type="button" class="min-w-[90px]"
                                    x-on:click="
                                        showCommittee(item.id);
                                        $el.blur();
                                   "
                                >
                                    Alterar
                                </x-button>
                            </template>
                            <template x-if="item.state">
                                <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(item.id)"
                                                 x-on:click="warning('confirmação', item.name, item.id, 'inativar'); $el.blur();">
                                    <template x-if="isInactivating(item.id)">
                                        <span>Inativando...</span>
                                    </template>
                                    <template x-if="!isInactivating(item.id)">
                                        <span>Inativar</span>
                                    </template>
                                </x-danger-button>
                            </template>
                            <template x-if="!item.state">
                                <x-management.activate-button type="button" class="min-w-[98px]" x-bind:disabled="isActivating(item.id)"
                                    x-on:click="
                                        warning('confirmação',item.name, item.id, 'ativar');
                                        $el.blur();
                                    "
                                >
                                    <template x-if="isActivating(item.id)">
                                        <span>Ativando...</span>
                                    </template>
                                    <template x-if="!isActivating(item.id)">
                                        <span>Ativar</span>
                                    </template>
                                </x-management.activate-button>
                            </template>
                        @endcan
                        @cannot('manage-events')
                            @can('evaluate')
                                <template x-if="item.belongsTo && !item.evaluatedByUser">
                                    <x-secondary-button x-on:click="$el.blur(); openEvaluationForm(item.id);">Avaliar</x-secondary-button>
                                </template>

                                <template x-if="!item.belongsTo || item.evaluatedByUser">
                                    <x-secondary-button x-on:click="$el.blur(); openEvaluationForm(item.id);">Avaliação</x-secondary-button>
                                </template>
                            @else
                                <template x-if="item.belongsTo || !item.belongsTo">
                                    <x-secondary-button x-on:click="$el.blur(); openEvaluationForm(item.id);">Avaliação</x-secondary-button>
                                </template>
                            @endcan
                        @endcannot
                    </x-slot>
                </x-card.content>

                {{-- Card dos grupos --}}
                <x-card.content
                    x-show="getCardType(item.id) === 'group'"
                    :listMeta="['count' => 'students', 'icon' => 'users', 'sinTitle' => 'Aluno', 'pluTitle' => 'Alunos']"
                >
                    <x-slot name="header">
                        <span x-text="item.group_id" class="text-sm text-gray-600 dark:text-gray-200 me-3 transition duration-150 ease-in-out"></span>
                        <button class="px-3 my-1 whitespace-nowrap ms-auto bg-primary-orange rounded-md text-white dark:text-gray-200 text-sm"
                            x-on:click="
                                $el.blur();
                                setCardType(item.id, 'committee');
                            "
                        >
                            Banca &raquo;
                        </button>
                    </x-slot>

                    <x-slot name="title">
                        <h3 class="text-lg font-semibold line-clamp-2 leading-snug" x-text="item.group_theme"></h3>
                    </x-slot>

                    <x-slot name="list">
                        <template x-for="student in item.students" :key="student.ra">
                            <li
                                x-text="student.name"
                                :class="student.state == 0 ? 'line-through text-gray-400' : ''"
                            ></li>
                        </template>
                    </x-slot>
                    @can('manage-events')
                        <x-slot name="state">
                            <span
                                class="inline-flex text-xs py-1 ms-4 px-3 font-bold rounded-s-lg rounded-e-lg transition duration-150 ease-in-out"
                                :class="item?.group_state === 1
                                ? 'bg-secondary-blue text-white dark:text-gray-200'
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200'"
                                x-text="item?.group_state === 1 ? 'Ativo' : 'Inativo'">
                            </span>
                        </x-slot>
                    @endcan

                    <x-slot name="paperAction">
                        <template x-if="item?.paper?.evaluation && selectedVersion[item.id] === 'evaluation'">
                            <x-card.link-button
                                x-on:click="showPaper(item.paper.evaluation.file_path)"
                            >
                                <x-lucide-file-text class="w-4 h-4 text-gray-600 dark:text-gray-200 transition duration-150 ease-in-out flex-shrink-0"/>
                                <span class="text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-semibold truncate" x-text="item.paper.evaluation.title"></span>

                                <x-slot name="optionsButton">
                                    <button
                                        type="button"
                                        class="flex items-center ms-auto max-w-full justify-start rounded-md gap-2 px-3 py-2 hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer"
                                        x-on:click.stop="paperOptions[item.id] = !paperOptions[item.id]"
                                    >
                                        <x-lucide-ellipsis-vertical
                                            class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 ms-auto transition duration-150 ease-in-out"/>
                                    </button>
                                </x-slot>

                                <x-slot name="actions">
                                    <div x-show="paperOptions[item.id]" class="flex flex-wrap w-full justify-around">
                                        <button
                                            type="button"
                                            class="flex items-center min-w-0 max-w-full w-1/3 rounded-md justify-center gap-2 px-4 py-1 hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer"
                                            x-on:click="showPaper(item.paper.evaluation.file_path)"
                                            title="Visualizar"
                                        >
                                            <x-lucide-eye class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 transition duration-150 ease-in-out"/>
                                            <span class="hidden xs:block text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-medium truncate">Visualizar</span>
                                        </button>
                                        <button
                                            type="button"
                                            class="flex items-center min-w-0 max-w-full w-1/3 rounded-md justify-center gap-2 px-4 py-1 hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer"
                                            x-on:click="window.open(item.paper.evaluation.file_path, '_blank')"
                                            title="Nova aba"
                                        >
                                            <x-lucide-external-link class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 transition duration-150 ease-in-out"/>
                                            <span class="hidden xs:block text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-medium truncate">Nova aba</span>
                                        </button>
                                        <a
                                            :href="item.paper.evaluation.file_path"
                                            download
                                            class="flex items-center min-w-0 max-w-full w-1/3 rounded-md justify-center gap-2 px-4 py-1 hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer"
                                            title="Baixar"
                                        >
                                            <x-lucide-download class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 transition duration-150 ease-in-out"/>
                                            <span class="hidden xs:block text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-medium truncate">Baixar</span>
                                        </a>
                                    </div>
                                </x-slot>
                            </x-card.link-button>
                        </template>

                        <template x-if="item?.paper?.corrected && selectedVersion[item.id] === 'corrected'">
                            <x-card.link-button
                                x-on:click="showPaper(item.paper.corrected.file_path)"
                            >
                                <x-lucide-file-text class="w-4 h-4 text-gray-600 dark:text-gray-200 transition duration-150 ease-in-out flex-shrink-0"/>
                                <span class="text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-semibold truncate" x-text="item.paper.corrected.title"></span>

                                <x-slot name="optionsButton">
                                    <button
                                        type="button"
                                        class="flex items-center ms-auto max-w-full justify-start rounded-md gap-2 px-3 py-2 hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer"
                                        x-on:click.stop="paperOptions[item.id] = !paperOptions[item.id]"
                                    >
                                        <x-lucide-ellipsis-vertical
                                            class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 ms-auto transition duration-150 ease-in-out"/>
                                    </button>
                                </x-slot>

                                <x-slot name="actions">
                                    <div x-show="paperOptions[item.id]" class="flex flex-wrap w-full justify-around">
                                        <button
                                            type="button"
                                            class="flex items-center min-w-0 max-w-full w-1/3 rounded-md justify-center gap-2 px-4 py-1 hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer"
                                            x-on:click="showPaper(item.paper.corrected.file_path)"
                                            title="Visualizar"
                                        >
                                            <x-lucide-eye class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 transition duration-150 ease-in-out"/>
                                            <span class="hidden xs:block text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-medium truncate">Visualizar</span>
                                        </button>
                                        <button
                                            type="button"
                                            class="flex items-center min-w-0 max-w-full w-1/3 rounded-md justify-center gap-2 px-4 py-1 hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer"
                                            x-on:click="window.open(item.paper.corrected.file_path, '_blank')"
                                            title="Nova aba"
                                        >
                                            <x-lucide-external-link class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 transition duration-150 ease-in-out"/>
                                            <span class="hidden xs:block text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-medium truncate">Nova aba</span>
                                        </button>
                                        <a
                                            :href="item.paper.corrected.file_path"
                                            download
                                            class="flex items-center min-w-0 max-w-full w-1/3 rounded-md justify-center gap-2 px-4 py-1 hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer"
                                            title="Baixar"
                                        >
                                            <x-lucide-download class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 transition duration-150 ease-in-out"/>
                                            <span class="hidden xs:block text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-medium truncate">Baixar</span>
                                        </a>
                                    </div>
                                </x-slot>
                            </x-card.link-button>
                        </template>
                    </x-slot>

                    <x-slot name="actions">
                        {{-- Botões de alternância entre as versões dos trabalhos --}}
                        <template x-if="item?.paper?.corrected">
                            <div class="flex flex-wrap gap-2">
                                <button
                                    x-on:click="selectedVersion[item.id] = 'evaluation'"
                                    :class="selectedVersion[item.id] === 'evaluation'
                                    ? 'bg-royal-blue text-white'
                                    : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200'"
                                    class="text-sm px-3 py-1 rounded-md shadow-md transition"
                                    title="Trabalho avaliado"
                                >
                                    Avaliação
                                </button>

                                <button
                                    x-on:click="selectedVersion[item.id] = 'corrected'"
                                    :class="selectedVersion[item.id] === 'corrected'
                                    ? 'bg-royal-blue text-white'
                                    : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200'"
                                    class="text-sm px-3 py-1 rounded-md shadow-md transition"
                                    title="Trabalho corrigido"
                                >
                                    Corrigido
                                </button>
                            </div>
                        </template>
                    </x-slot>
                </x-card.content>
            </x-card.layout>
        </x-card.grid>
    </div>
</div>
