<div class="pt-8">
    <template x-if="created_at">
        <p class="text-sm text-gray-800 dark:text-gray-200" x-text="created_at"></p>
    </template>
    <template x-if="updated_at">
        <p class="text-sm text-gray-800 dark:text-gray-200" x-text="updated_at"></p>
    </template>
</div>
