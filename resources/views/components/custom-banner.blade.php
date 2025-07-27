<div x-show="showBanner" x-transition
     class="flex top-4 right-4 px-4 py-2 rounded shadow text-white z-50 mb-4"
     x-bind:class="{
                 'bg-green-600': style === 'success',
                 'bg-red-600': style === 'danger',
                 'bg-yellow-500': style === 'warning'
             }">
    <template x-if="style === 'success'">
        <x-lucide-check-circle class="w-4 h-4 mr-2 mt-[4px]"/>
    </template>
    <template x-if="style === 'danger'">
        <x-lucide-x-circle class="w-4 h-4 mr-2 mt-[4px]"/>
    </template>
    <template x-if="style === 'warning'">
        <x-lucide-alert-triangle class="w-4 h-4 mr-2 mt-[4px]"/>
    </template>
    <span x-text="message"></span>
</div>

