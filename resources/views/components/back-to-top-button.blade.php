<button id="backToTop" type="button" title="Voltar ao topo"
        class="hidden fixed right-2 bottom-2 bg-white border border-gray-200 shadow opacity-50 hover:opacity-100 rounded-full p-4">
    <x-lucide-chevron-up class="text-gray-700 w-4 h-4"/>
</button>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > window.innerHeight * 0.6) {
                backToTop.classList.remove('hidden');
            } else {
                backToTop.classList.add('hidden');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
