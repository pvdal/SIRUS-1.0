<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0
    bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300
    dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="w-full sm:max-w-lg my-6
        bg-gradient-to-br from-white via-gray-50 to-gray-100
        dark:from-slate-900/70 dark:via-slate-900/50 dark:to-slate-800/70
        backdrop-blur-md
        border border-gray-100 dark:border-gray-950
        shadow-lg overflow-hidden sm:rounded-lg">
        <div class="flex flex-col items-center w-full rounded-md overflow-hidden">
            <div class="w-full flex pt-12 justify-center">
                {{ $logo }}
            </div>
        </div>

        <div class="w-full p-10 shadow-md overflow-hidden sm:rounded-b-lg">
            {{ $slot }}
        </div>
    </div>
    <footer class="w-full sm:max-w-md mx-auto px-4 mb-6">
        <div class="flex flex-col gap-4 text-center">
            <!-- Copyright -->
            <p class="text-sm text-gray-500 dark:text-gray-400">
                &copy; 2026. Todos os direitos reservados.
            </p>
        </div>
    </footer>
</div>
