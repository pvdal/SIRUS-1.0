<div>
    {{-- Nome do professor --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Professor"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full"
                 placeholder="Nome do professor" x-model="name"
                 @keydown.enter="saveCoordinator"/>
        <template x-if="errors.name">
            <p class="text-red-600 text-sm" x-text="errors.name[0]"></p>
        </template>
    </div>

    {{-- Email do professor --}}
    <div class="mt-4">
        <x-label for="email" value="Email do Professor"/>
        <x-input id="email" type="text" autocomplete="email" class="w-full"
                 placeholder="E-mail do professor" x-model="email"
                 @keydown.enter="saveProfessor"/>
        <template x-if="errors.email">
            <p class="text-red-600 text-sm" x-text="errors.email[0]"></p>
        </template>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <div class="mt-5">
            <p class="text-sm text-gray-800" x-text="created_at"></p>
            <p class="text-sm text-gray-800" x-text="updated_at"></p>
        </div>
    </template>
</div>
