@props(['type' => 'evaluation'])

<div>
    @if($type === 'create')
        <template x-if="events.length < 1">
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
            type="text"
            @input="eventId = eventId.replace(/\D/g,'')"
            x-model="eventId"
            :disabled="{{ Gate::denies('manage-events') ? 'true' : ($type === 'evaluation' ? 'true' : 'events.length < 1') }}"
            :readonly="{{ Gate::denies('manage-events') ? 'true' : ($type === 'evaluation' ? 'true' : 'false') }}"
            class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm mt-1 dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-300 transition duration-150 ease-in-out"
            placeholder="ID da banca"
        />
    </div>

    @if($type === 'create')
        <div class="mt-4">
            <x-label for="event_id" value="Bancas"/>
            <x-select id="event_id" x-model="eventId" class="w-full mt-1"
                x-bind:disabled="{{ Gate::denies('manage-events') ? 'true' : 'events.length < 1' }}"
                x-bind:readonly="{{ Gate::denies('manage-events') ? 'true' : 'events.length < 1' }}"
            >
                <option value="" selected>Selecione uma banca</option>
                <template x-for="event in events" :key="event.id">
                    <option
                        :value="event.id"
                        x-text="event.title ?? '-'">
                    </option>
                </template>
            </x-select>
            <template x-if="errors.eventId">
                <x-form-fields.field-error x-text="errors.eventId[0]"/>
            </template>
        </div>
    @else
        <div class="mt-4">
            <x-label for="name" value="Nome da banca"/>
            <x-input id="name" type="text" class="w-full mt-1"
                     placeholder="Nome da banca" x-model="eventTitle"
                     readonly disabled/>
        </div>
    @endif

    <div class="mt-4">
        <x-label for="group" value="Nome do grupo"/>
        <x-input id="name" type="text" class="w-full mt-1"
                 placeholder="Nome do grupo" x-model="group"
                 readonly disabled/>
    </div>

    <div class="mt-4">
        <x-label for="paper" value="Título do trabalho"/>
        <x-input id="name" type="text" class="w-full mt-1"
                 placeholder="Título do trabalho" x-model="paper"
                 readonly disabled/>
    </div>

    {{-- Membros da banca --}}
    <x-form-fields.selected-list
        :title="'Membros da banca:'"
        :list="'members'"
        :key="'user_id'"
    >
        <span>
            <span x-text="(item.name ?? 'Sem nome') + ' - ' + (item.member_type?.name ?? 'Sem função')"></span>
        </span>
    </x-form-fields.selected-list>


    {{-- Definição de data --}}
    <div class="flex flex-wrap sm:flex-nowrap gap-4 justify-center xs:justify-between mt-4">
        <fieldset class="flex flex-col justify-center items-center w-1/2">
            <div>
                <legend class="text-sm font-medium w-full text-center xs:text-start">Data/hora de início</legend>
                <div class="flex flex-col xs:flex-row items-center gap-2 mt-1">
                    <div>
                        <x-input
                            type="date"
                            class="w-full text-center"
                            x-model="dateStart"
                            x-bind:disabled="(showEvaluationModal && !edit) || (showCreateModal && events.length < 1)"/>
                    </div>
                    <div>
                        <x-input
                            type="time"
                            step="1"
                            class="w-full text-center"
                            x-model="timeStart"
                            x-bind:disabled="(showEvaluationModal && !edit) || (showCreateModal && events.length < 1)"/>
                    </div>
                </div>
                <template x-if="errors?.date_start || errors?.time_start">
                    <div class="flex flex-wrap">
                        <x-form-fields.field-error x-text="errors.date_start?.[0]"/>
                        <x-form-fields.field-error x-text="errors.time_start?.[0]"/>
                    </div>
                </template>
            </div>
        </fieldset>

        <fieldset class="flex justify-center w-1/2">
            <div>
                <legend class="text-sm font-medium w-full text-center xs:text-start">Data/hora de fim</legend>
                <div class="flex flex-col xs:flex-row items-center gap-2 mt-1">
                    <div>
                        <x-input
                            type="date"
                            class="w-full text-center"
                            x-model="dateEnd"
                            x-bind:disabled="(showEvaluationModal && !edit) || (showCreateModal && events.length < 1)"/>
                    </div>
                    <div>
                        <x-input
                            type="time"
                            step="1"
                            class="w-full text-center"
                            x-model="timeEnd"
                            x-bind:disabled="(showEvaluationModal && !edit) || (showCreateModal && events.length < 1)"/>
                    </div>
                </div>
                <template x-if="errors?.date_end || errors?.time_end">
                    <div class="flex flex-wrap">
                        <x-form-fields.field-error x-text="errors.date_end?.[0]"/>
                        <x-form-fields.field-error x-text="errors.time_end?.[0]"/>
                    </div>
                </template>
            </div>
        </fieldset>
    </div>
</div>
