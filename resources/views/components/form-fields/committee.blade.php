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
    {{-- Trabalho --}}
    <div x-show="groupSelected" class="mt-4">
        <x-label for="paper_id" value="Trabalho"/>
        <x-select id="paper_id" class="w-full mt-1" x-model="paper_id" x-bind:disabled="!groupSelected">
            <option value="">Selecione um artigo</option>
            <template x-for="paper in papers" :key="paper.id">
                <option :value="paper.id" x-text="paper.title ?? '-'"></option>
            </template>
        </x-select>
        <template x-if="errors.paper_id">
            <x-form-fields.field-error x-text="errors.paper_id[0]"/>
        </template>
    </div>

    {{-- Rubrica --}}
    <div class="mt-4">
        <x-label for="rubric_id" value="Rubrica"/>
        <x-select id="rubric_id" class="w-full mt-1" x-model="rubric_id">
            <option value="" selected>Selecione uma rubrica</option>

        </x-select>
        <template x-if="errors.rubric_id">
            <x-form-fields.field-error x-text="errors.rubric_id[0]"/>
        </template>
    </div>

    {{-- Membros --}}
    <div id="members" class="space-y-2 pt-4">
        {{-- ID do Tipo de Membro --}}
        <div id="type" class="mt-4">
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
                x-bind:class="{ 'border rounded bg-gray-200 dark:bg-gray-700 shadow-sm dark:shadow-gray-500': filteredMembers.length > 0}"
            >
                <template x-if="searching">
                    <li class="p-2 text-gray-500">Buscando...</li>
                </template>

                <template x-for="member in filteredMembers" :key="member.user_id">
                    <li
                        class="p-2 border-b"
                        @click="!member.committee && addMember(member)"
                        :class="{ 'opacity-50 cursor-normal': member.committee, 'cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600': !member.committee }"
                    >
                        <div>
                            <span x-text="member.user_type.name + ': ' + member.name + ' - ' + member.id"></span>
                        </div>
                        <template x-if="member.committee">
                            <div>
                                <span x-text="'Banca:' + member.committee"></span>
                            </div>
                        </template>
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
        <span>
            <span x-text="(item.user_type?.name ?? 'Sem tipo') + ': ' + item.name + ' - ' + (item.member_type?.name ?? 'Sem função')"></span>
        </span>
        <x-form-fields.remove-button :action="'removeMember'" :key="'item.user_id'"/>
    </x-form-fields.selected-list>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
