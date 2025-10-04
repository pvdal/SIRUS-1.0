@props(['type' => 'evaluation'])

<div>
    @if($type === 'create')
        <template x-if="committees.length < 1">
            <div class="rounded-xl bg-secondary-blue p-2 px-4">
                <h3 class="block font-medium text-sm text-white">
                    Não há bancas sem datas definidas.
                </h3>
            </div>
        </template>
    @endif

    <div class="mt-4">
        <x-label for="id" value="ID da banca"/>
        <input
            id="id"
            type="number"
            x-model="committeeId"
            :disabled="@cannot('manage-events') true @else committees.length < 1 @endcannot"
            class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm mt-1"
            placeholder="ID da banca"
            @cannot('manage-events') readonly @endcannot
        />
    </div>

    @if($type === 'create')
        <div class="mt-4">
            <x-label for="committee_id" value="Bancas"/>
            <select id="committee_id" class="w-full rounded border-gray-300" x-model="committeeId" >
                <option value="" selected>Selecione uma banca</option>
                <template x-for="committee in committees" :key="committee.id">
                    <option
                        :value="committee.id"
                        x-text="committee.title ?? '-'">
                    </option>
                </template>
            </select>
            <template x-if="errors.committeeId">
                <p class="text-red-600 text-sm" x-text="errors.committeeId[0]"></p>
            </template>
        </div>
    @else
        <div class="mt-4">
            <x-label for="name" value="Nome da banca"/>
            <x-input id="name" type="text" class="w-full"
                     placeholder="Nome da banca" x-model="committeeTitle"
                     readonly disabled/>
        </div>
    @endif

    <div class="mt-4">
        <x-label for="group" value="Nome do grupo"/>
        <x-input id="name" type="text" class="w-full"
                 placeholder="Nome do grupo" x-model="group"
                 readonly disabled/>
    </div>

    <div class="mt-4">
        <x-label for="paper" value="Título do trabalho"/>
        <x-input id="name" type="text" class="w-full"
                 placeholder="Título do trabalho" x-model="paper"
                 readonly disabled/>
    </div>

    {{-- Membros da banca --}}
    <div x-show="members.length >0 " class="mt-4">
        <h4 class="font-semibold">Membros da banca:</h4>
        <ul class="space-y-1 mt-2">
            <template x-for="member in members" :key="member.user_id">
                <li class="flex items-center justify-between bg-gray-100 p-2 rounded">
                    <span>
                        <span x-text="(member.name ?? 'Sem nome') + ' - ' + (member.member_type?.name ?? 'Sem função')"></span>
                    </span>
                </li>
            </template>
        </ul>
    </div>

    {{-- Definição de data --}}
    <div class="flex flex-wrap gap-2 justify-center xs:justify-between mt-4">
        <fieldset class="max-w-[50%]">
            <legend class="text-sm font-medium w-full text-center xs:text-start">Data/hora inicial</legend>
            <div class="flex flex-col xs:flex-row items-center gap-2">
                <div>
                    <input
                        type="date"
                        class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm mt-1"
                        x-model="dateStart"
                        :disabled="(showEvaluationModal && !edit) || (showCreateModal && committees.length < 1)"/>
                </div>
                <div>
                    <input
                        type="time"
                        step="1"
                        class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm mt-1"
                        x-model="timeStart"
                        :disabled="(showEvaluationModal && !edit) || (showCreateModal && committees.length < 1)"/>
                </div>
            </div>
            <template x-if="errors?.dateStart || errors?.timeStart">
                <div class="flex flex-wrap">
                    <p class="text-red-600 text-sm" x-text="errors.dateStart?.[0]"></p>
                    <p class="text-red-600 text-sm" x-text="errors.timeStart?.[0]"></p>
                </div>
            </template>
        </fieldset>

        <fieldset class="max-w-[50%]">
            <legend class="text-sm font-medium w-full text-center xs:text-start">Data/hora final</legend>
            <div class="flex flex-col xs:flex-row items-center gap-2">
                <div>
                    <input
                        type="date"
                        class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm mt-1"
                        x-model="dateEnd"
                        :disabled="(showEvaluationModal && !edit) || (showCreateModal && committees.length < 1)"/>
                </div>
                <div>
                    <input
                        type="time"
                        step="1"
                        class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm mt-1"
                        x-model="timeEnd"
                        :disabled="(showEvaluationModal && !edit) || (showCreateModal && committees.length < 1)"/>
                </div>
            </div>
            <template x-if="errors?.dateEnd || errors?.timeEnd">
                <div class="flex flex-wrap">
                    <p class="text-red-600 text-sm" x-text="errors.dateEnd?.[0]"></p>
                    <p class="text-red-600 text-sm" x-text="errors.timeEnd?.[0]"></p>
                </div>
            </template>
        </fieldset>
    </div>
</div>
