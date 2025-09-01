<div>
    {{-- Nome do coordenador --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Coordenador"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full"
                 placeholder="Nome do coordenador" x-model="name"
                 @keydown.enter="saveCoordinator"/>
        <template x-if="errors.name">
            <p class="text-red-600 text-sm" x-text="errors.name[0]"></p>
        </template>
    </div>
    {{-- Email do coordenador --}}
    <div class="mt-4">
        <x-label for="email" value="Email do Coordenador"/>
        <x-input id="email" type="text" autocomplete="email" class="w-full"
                 placeholder="E-mail do coordenador" x-model="email"
                 @keydown.enter="saveCoordinator"/>
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
