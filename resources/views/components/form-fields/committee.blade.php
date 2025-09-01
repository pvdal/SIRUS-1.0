<div class="space-y-2">
    {{-- Nome da banca --}}
    <div class="mt-4">
        <x-label for="name" value="Nome da Banca"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full"
                 placeholder="Nome da banca" x-model="name"
                 @keydown.enter="saveCommittee"/>
        <template x-if="errors.name">
            <p class="text-red-600 text-sm" x-text="errors.name[0]"></p>
        </template>
    </div>

    {{-- Grupo --}}
    <div class="mt-4">
        <x-label for="group_id" value="Grupo"/>
        <select id="group_id" class="w-full rounded border-gray-300" x-model="group_id">
            <option value="" selected>Selecione um grupo</option>
            <template x-for="group in groups" :key="group.id">
                <option
                    :value="group.id"
                    :disabled="group.state == 0"
                    x-text="group.state == 0 ? `[INATIVO] ${group.theme ?? '-'}` : (group.theme ?? '-')">
                </option>
            </template>
        </select>
        <template x-if="errors.group_id">
            <p class="text-red-600 text-sm" x-text="errors.group_id[0]"></p>
        </template>
    </div>
    {{-- Trabalho --}}
    <div x-show="groupSelected" class="mt-4">
        <x-label for="paper_id" value="Trabalho"/>
        <select id="paper_id" class="w-full rounded border-gray-300" x-model="paper_id" x-bind:disabled="!groupSelected">
            <option value="">Selecione um artigo</option>
            <template x-for="paper in papers" :key="paper.id">
                <option :value="paper.id" x-text="paper.title ?? '-'"></option>
            </template>
        </select>
        <template x-if="errors.paper_id">
            <p class="text-red-600 text-sm" x-text="errors.paper_id[0]"></p>
        </template>
    </div>

    {{-- Rubrica --}}
    <div class="mt-4">
        <x-label for="rubric_id" value="Rubrica"/>
        <select id="rubric_id" class="w-full rounded border-gray-300" x-model="rubric_id">
            <option value="" selected>Selecione uma rubrica</option>

        </select>
        <template x-if="errors.rubric_id">
            <p class="text-red-600 text-sm" x-text="errors.rubric_id[0]"></p>
        </template>
    </div>

    {{-- Membros --}}
    <div id="members" class="space-y-2 pt-2">
        {{-- ID do Tipo de Membro --}}
        <div id="type" class="mt-4">
            <x-label for="memberType_id" value="Tipo de membro"/>
            <select id="memberType_id" class="w-full rounded border-gray-300" x-model="member_type_id">
                <option value="" selected disabled>Selecione o tipo de membro</option>
                <template x-for="memberType in memberTypes" :key="memberType.id">
                    <option :value="memberType.id" x-text="memberType.name ?? '-'"></option>
                </template>
            </select>
            <template x-if="errors.members">
                <p class="text-red-600 text-sm" x-text="errors.members[0]"></p>
            </template>
        </div>

        <div x-show="member_type_id">
            {{-- ID do Member --}}
            <div class="mt-4">
                <x-label for="searchMember" value="Busque os membros da banca"/>
                <x-input id="searchMember" type="search" autocomplete="off" class="w-full"
                         placeholder="Buscar membro por nome ou ID..." x-model="searchMember"/>
            </div>
            {{-- Lista de sugestões --}}
            <template x-if="!filteredMembers.length && searchMember && !searching && showNoMembersMsg">
                <p class="p-2 text-gray-500">Nenhum docente encontrado.</p>
            </template>
            <ul x-show="filteredMembers.length > 0 || searching" class="max-h-60 overflow-y-auto scrollbar-custom"
                x-bind:class="{ 'border rounded bg-gray-50 drop-shadow-sm': filteredMembers.length > 0}"
            >
                <template x-if="searching">
                    <li class="p-2 text-gray-500">Buscando...</li>
                </template>

                <template x-for="member in filteredMembers" :key="member.user_id">
                    <li
                        class="p-2 border-b"
                        @click="!member.committee && addMember(member)"
                        :class="{ 'opacity-50 cursor-normal': member.committee, 'cursor-pointer hover:bg-blue-100': !member.committee }"
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
    <div x-show="members.length >0 " class="mt-4">
        <h4 class="font-semibold">Membros selecionados:</h4>
        <ul class="space-y-1 mt-2">
            <template x-for="member in members" :key="member.user_id">
                <li class="flex items-center justify-between bg-gray-100 p-2 rounded">
                <span>
                    <span x-text="(member.user_type?.name ?? 'Sem tipo') + ': ' + member.name + ' - ' + (member.member_type?.name ?? 'Sem função')"></span>
                </span>
                    <button
                        class="text-red-500 hover:text-red-700"
                        @click="removeMember(member.user_id)"
                        title="Remover"
                    >
                        ✕
                    </button>
                </li>
            </template>
        </ul>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <div class="mt-5">
            <p class="text-sm text-gray-800" x-text="created_at"></p>
            <p class="text-sm text-gray-800" x-text="updated_at"></p>
        </div>
    </template>
</div>
