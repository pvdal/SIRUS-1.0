<div>
    {{-- Nome da banca --}}
    <div class="mt-4">
        <x-label for="name" value="Nome da Banca"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full mt-1"
                 placeholder="Nome da banca" x-model="name"
                 @keydown.enter="saveCommittee"/>
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]"/>
        </template>
    </div>

    {{-- Grupo --}}
    <div class="mt-4">
        <x-label for="group_id" value="Grupo"/>
        <x-select id="group_id" class="w-full mt-1" x-model="group_id">
            <option value="" selected>Selecione um grupo</option>
            <template x-for="group in groups" :key="group.id">
                <option
                    :value="group.id"
                    :disabled="group.state == 0"
                    x-text="group.state == 0 ? `[INATIVO] ${group.theme ?? '-'}` : (group.theme ?? '-')">
                </option>
            </template>
        </x-select>
        <template x-if="errors.group_id">
            <x-form-fields.field-error x-text="errors.group_id[0]"/>
        </template>
    </div>
    {{-- Trabalho de avaliação --}}
    <div x-show="groupSelected" class="mt-4">
        <x-label for="paper_id_evaluation" value="Trabalho"/>
        <x-select id="paper_id_evaluation" class="w-full mt-1" x-model="paper_id.evaluation" x-bind:disabled="!groupSelected">
            <option value="">Selecione um artigo</option>
            <template x-for="paper in papers.evaluation" :key="paper.id">
                <option :value="paper.id" x-text="paper.title ?? '-'"></option>
            </template>
        </x-select>
        <template x-if="errors.paper_id">
            <x-form-fields.field-error x-text="errors.paper_id[0]"/>
        </template>
    </div>
    {{-- Trabalho corrigido
    <template x-if="edit && submittedPaper">
        <div x-show="groupSelected" class="mt-4">
            <x-label for="paper_id_corrected" value="Trabalho corrigido (opcional)"/>
            <x-select id="paper_id_corrected" class="w-full mt-1" x-model="paper_id.corrected" x-bind:disabled="!groupSelected">
                <option value="">Selecione um artigo</option>
                <template x-for="paper in papers.corrected" :key="paper.id">
                    <option :value="paper.id" x-text="paper.title ?? '-'"></option>
                </template>
            </x-select>
            <template x-if="errors.corrected_paper_id">
                <x-form-fields.field-error x-text="errors.corrected_paper_id[0]"/>
            </template>
        </div>
    </template>
    --}}
    {{-- Rubrica
    <div class="pt-4">
        <div class="mt-4">
            <x-label for="group_rubric" value="Rubrica em grupo"/>
            <x-select id="group_rubric" class="w-full mt-1" x-model="rubric_id">
                <option value="">Selecione uma rubrica</option>
                <template x-for="rubric in rubrics.filter(r => r.type === 1)" :key="rubric.id">
                    <option :value="rubric.id" x-text="rubric.name ?? '-'"></option>
                </template>
            </x-select>
            <template x-if="errors.group_rubric">
                <x-form-fields.field-error x-text="errors.group_rubric[0]"/>
            </template>
        </div>

        <div class="mt-4">
            <x-label for="individual_rubric" value="Rubrica individual"/>
            <x-select id="individual_rubric" class="w-full mt-1">
                <option value="">Selecione uma rubrica</option>
                <template x-for="rubric in rubrics.filter(r => r.type === 2)" :key="rubric.id">
                    <option :value="rubric.id" x-text="rubric.name ?? '-'"></option>
                </template>
            </x-select>
            <template x-if="errors.individual_rubric">
                <x-form-fields.field-error x-text="errors.individual_rubric[0]"/>
            </template>
        </div>
    </div>--}}

    {{-- Campo de busca para os Rubricas --}}
    <div class="pt-4">
        <x-label for="searchRubrics" value="Rubricas"/>
        <x-input id="searchRubrics" type="search"
                 x-model="searchRubric"
                 placeholder="Buscar Rubrica..."
                 class="w-full mt-1"/>
        {{-- Exibição de erro geral para os eixos (ex: "É necessário pelo menos um eixo") --}}
        <template x-if="errors.rubrics">
            <x-form-fields.field-error x-text="errors.rubrics[0]"/>
        </template>
    </div>

    {{-- Lista de sugestões de Rubricas --}}
    <template x-if="!filteredRubrics.length && searchRubrics && !searching && showNoRubricsMsg">
        <p class="p-2 text-gray-500">Nenhuma rubrica encontrada.</p>
    </template>
    <ul x-show="filteredRubrics.length > 0 || searching" class="max-h-80 overflow-y-auto scrollbar-custom"
        x-bind:class="{ 'border rounded bg-gray-100 dark:bg-gray-700 shadow-sm dark:shadow-gray-700': filteredRubrics.length > 0}"
    >
        <template x-if="searching && searchingRubrics">
            <li class="p-2 text-gray-500">Buscando...</li>
        </template>

        <template x-for="rubric in filteredRubrics" :key="rubric.id">
            <li
                class="p-2 border-b border-gray-300 cursor-pointer hover:bg-gray-200/50 dark:hover:bg-gray-600"
                x-on:click="
                    if(!rubric.belongsTo) {
                        addRubric(rubric);
                        rubric.belongsTo = true;
                    }
                "
                x-on:remove-rubric.window="
                    if($event.detail === rubric.id) {
                        rubric.belongsTo = false;
                    }
                "
                :class="{
                    'line-through opacity-60 bg-gray-200/50 dark:bg-gray-600 !cursor-default ': rubric.belongsTo
                }"
            >
                <span x-text="rubric.name"></span> - <span x-text="rubric.type === 1 ? 'Grupo' : 'Individual' "></span>
            </li>
        </template>
    </ul>

    <div x-show="rubrics.length > 0" class="pt-4">
        <h4 class="font-medium text-gray-700 dark:text-gray-200">Rubricas selecionadas:</h4>
        <ul class="space-y-1 mt-1">
            {{-- Para cada eixo na nossa lista 'axes'... --}}
            <template x-for="(rubric, index) in rubrics" :key="rubric.id">
                <div>
                    <li class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-2 px-4 rounded">

                        {{-- Um container para o nome da rubrica e o seu campo de peso --}}
                        <div class="flex flex-wrap items-center flex-grow gap-4">
                            <span x-text="rubric.name + ' - ' + (rubric.type === 1 ? 'Grupo' : 'Individual')"
                                  class="mr-auto line-clamp-2"
                            ></span>
                            {{-- Campo para definir o peso da rubrica --}}
                            <div class="flex flex-wrap items-center gap-2">
                                <x-label x-bind:for="'weight-' + rubric.id">Peso:</x-label>
                                <x-input x-bind:id="'weight-' + rubric.id" type="text"
                                    @input="
                                        rubric.weight = rubric.weight.replace(/\D/g, '');
                                        if (rubric.weight > 100) rubric.weight = 100;
                                    "
                                    x-model="rubric.weight"
                                    placeholder="%"
                                    class="w-16 text-center text-sm h-8"
                                />
                            </div>
                        </div>
                        {{-- Botão para remover o eixo (agora com uma pequena margem à esquerda) --}}
                        <x-form-fields.remove-button
                            class="ms-5"
                            :action="'removeRubric'"
                            :additional="'$dispatch(\'remove-rubric\', rubric.id);'"
                            title="Remover Eixo"
                            :key="'rubric.id'"/>
                    </li>
                    {{-- Exibição de erro para os pesos (ex: "Todos os eixos devem ter um peso") --}}
                    <template x-if="rubrics.length > 0 && errors && errors['rubrics.' + index + '.weight']">
                        <x-form-fields.field-error x-text="errors['rubrics.' + index + '.weight']?.[0]"/>
                    </template>
                </div>
            </template>
        </ul>

        <div class="mt-6">
            <p class="text-sm"
               :class="totalWeight === 100 ? 'text-green-600' : 'text-red-600 dark:text-red-400'">
                Soma total: <span x-text="totalWeight"></span>%
            </p>
            <template x-if="totalWeight !== 100">
                <p class="text-xs text-red-500 dark:text-red-300">A soma dos pesos deve ser exatamente 100%</p>
            </template>
        </div>
    </div>

    {{-- Membros --}}
    <div id="members" class="space-y-2 mt-4">
        {{-- ID do Tipo de Membro --}}
        <div id="type">
            <x-label for="memberType_id" value="Tipo de membro"/>
            <x-select id="memberType_id" class="w-full mt-1" x-model="member_type_id">
                <option value="" selected disabled>Selecione o tipo de membro</option>
                <template x-for="memberType in memberTypes" :key="memberType.id">
                    <option :value="memberType.id" x-text="memberType.name ?? '-'"></option>
                </template>
            </x-select>
            <template x-if="errors.members">
                <x-form-fields.field-error x-text="errors.members[0]"/>
            </template>
        </div>

        <div x-show="member_type_id">
            {{-- ID do Member --}}
            <div class="mt-4">
                <x-label for="searchMember" value="Busque os membros da banca"/>
                <x-input id="searchMember" type="search" autocomplete="off" class="w-full mt-1"
                         placeholder="Buscar membro por nome ou ID..." x-model="searchMember"/>
            </div>
            {{-- Lista de sugestões --}}
            <template x-if="!filteredMembers.length && searchMember && !searching && showNoMembersMsg">
                <p class="p-2 text-gray-500">Nenhum docente encontrado.</p>
            </template>
            <ul x-show="filteredMembers.length > 0 || searching" class="max-h-80 overflow-y-auto scrollbar-custom"
                x-bind:class="{ 'border rounded bg-gray-100 dark:bg-gray-700 shadow-sm dark:shadow-gray-700': filteredMembers.length > 0}"
            >
                <template x-if="searching && searchingMembers">
                    <li class="p-2 text-gray-500">Buscando...</li>
                </template>

                <template x-for="member in filteredMembers" :key="member.user_id">
                    <li
                        class="p-2 border-b border-gray-300 cursor-pointer hover:bg-gray-200/50 dark:hover:bg-gray-600"
                        x-on:click="
                            if(!member.belongsTo) {
                                addMember(member);
                                member.belongsTo = true;
                            }
                        "
                        x-on:remove-member.window="
                            if($event.detail === member.user_id) {
                                member.belongsTo = false
                            }
                        "
                        :class="{
                            'line-through opacity-60 bg-gray-200/50 dark:bg-gray-600 !cursor-default ': member.belongsTo
                        }"
                    >
                        <div>
                            <span x-text="member.user_type.name + ': ' + member.name + ' - ' + member.id"></span>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    {{-- Membros adicionados --}}
    <x-form-fields.selected-list
        :title="'Membros selecionados:'"
        :list="'members'"
        :key="'user_id'"
    >
        <span class="ms-1 flex flex-wrap overflow-hidden max-w-[90%]">
            <span class="truncate block xs:whitespace-normal max-w-full mr-1" x-text="(item.user_type?.name ?? 'Sem tipo') + ':'"></span>
            <span class="truncate block xs:whitespace-normal max-w-full" x-text="item.name"></span>

            <span class="truncate">
                <span class="whitespace-nowrap ml-1" x-text="'- ' + (item.member_type?.name ?? 'Sem função')"></span>
            </span>
        </span>
        <x-form-fields.remove-button class="ms-5" :action="'removeMember'" :additional="'$dispatch(\'remove-member\', item.user_id);'" :key="'item.user_id'"/>
    </x-form-fields.selected-list>

    <div id="notifyMembers" class="mt-4">
        <template x-if="!edit">
            <label class="flex items-center gap-2">
                <x-checkbox id="notification-newMember" x-model="sendNotification"/>
                <span>Notificar membros sobre participação na banca</span>
            </label>
        </template>
        <template x-if="hasNewMembers">
            <label class="flex items-center gap-2">
                <x-checkbox id="notification-newMember" x-model="sendNotification"/>
                <span>Notificar novo(s) membros sobre participação na banca</span>
            </label>
        </template>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
