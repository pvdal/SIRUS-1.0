<div>
    {{-- Nome do coordenador --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Coordenador"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full"
                 placeholder="Nome do coordenador" x-model="name"/>
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
</div>
