<div x-show="showBanner" x-transition
     class="flex flex-row justify-start items-center top-4 right-4 px-4 py-2 rounded shadow text-white z-50 mb-4"
     x-bind:class="{
         'bg-green-600': style === 'success',
         'bg-red-600': style === 'danger',
         'bg-yellow-500 dark:bg-yellow-600': style === 'warning'
     }">
    <template x-if="style === 'success'">
        <x-lucide-check-circle class="w-4 h-4 mr-2 flex-shrink-0"/>
    </template>
    <template x-if="style === 'danger'">
        <x-lucide-x-circle class="w-4 h-4 mr-2 flex-shrink-0"/>
    </template>
    <template x-if="style === 'warning'">
        <x-lucide-alert-triangle class="w-4 h-4 mr-2 flex-shrink-0"/>
    </template>
    <span x-text="message"></span>
</div>

