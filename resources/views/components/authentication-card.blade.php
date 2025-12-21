<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-800">
    <div class="w-full sm:max-w-md mt-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-950 shadow-md overflow-hidden sm:rounded-lg">
        <div class="w-full flex justify-center bg-gray-800 dark:bg-slate-950 p-3">
            {{ $logo }}
        </div>

        <div class="w-full sm:max-w-md pt-10 px-6 py-4 shadow-md overflow-hidden sm:rounded-b-lg">
            {{ $slot }}
        </div>
    </div>

</div>
