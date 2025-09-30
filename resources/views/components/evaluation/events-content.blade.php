<div>
    <x-custom-modal x-model="showCreateModal">
        <x-slot name="title">
            Agende a data de uma banca
        </x-slot>
        <x-slot name="content">
            <x-form-fields.event/>
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-custom-modal>


    <div class="p-0 border-4 rounded overflow-hidden border-strong-blue">
        <div class="bg-primary-blue bg-blend-darken">
            <h1 class="text-center text-white border-b border-gray-600 pb-5 p-4 text-base sm:text-lg md:text-2xl lg:text-3xl">
                AGENDA DE AVALIAÇÃO DO SIMBAJU
            </h1>
        </div>
        <div class="flex justify-center">
            <div id="calendar" class="p-4 w-full max-w-4xl">
                <!-- conteúdo do calendário -->
            </div>
        </div>
    </div>
</div>

