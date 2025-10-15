<div>
    {{-- Nome do Critério --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Critério"/>
        <x-input id="name" type="text" autocomplete="off" class="w-full"
                 placeholder="Ex: Ortografia e Gramática" x-model="name"
                 @keydown.enter.prevent="saveCriterion()"/>
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]"/>
        </template>
    </div>
    {{-- Descrição de Excelente --}}
    <div class="mt-4">
        <x-label for="excellent" value="Descrição de excelente"/>
        <textarea id="excellent" x-model="excellent" class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-300 transition duration-150 ease-in-out"
                  placeholder="Detalhes sobre excelente..." rows="2"></textarea>
        <template x-if="errors.excellent">
            <x-form-fields.field-error x-text="errors.excellent[0]"/>
        </template>
    </div>

    {{-- Descrição de Bom --}}
    <div class="mt-4">
        <x-label for="good" value="Descrição de bom"/>
        <textarea id="good" x-model="good" class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-300 transition duration-150 ease-in-out"
                  placeholder="Detalhes sobre bom..." rows="2"></textarea>
        <template x-if="errors.good">
            <x-form-fields.field-error x-text="errors.good[0]"/>
        </template>
    </div>

    {{-- Descrição de satisfactory --}}
    <div class="mt-4">
        <x-label for="satisfactory" value="Descrição de satisfatório"/>
        <textarea id="satisfactory" x-model="satisfactory" class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-300 transition duration-150 ease-in-out"
                  placeholder="Detalhes sobre satisfatório..." rows="2"></textarea>
        <template x-if="errors.satisfactory">
            <x-form-fields.field-error x-text="errors.satisfactory[0]"/>
        </template>
    </div>

    {{-- Descrição de Insatisfatório --}}
    <div class="mt-4">
        <x-label for="unsatisfactory" value="Descrição de insatisfatório"/>
        <textarea id="unsatisfactory" x-model="unsatisfactory" class="w-full border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-300 transition duration-150 ease-in-out"
                  placeholder="Detalhes sobre insatisfatório..." rows="2"></textarea>
        <template x-if="errors.unsatisfactory">
            <x-form-fields.field-error x-text="errors.unsatisfactory[0]"/>
        </template>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
