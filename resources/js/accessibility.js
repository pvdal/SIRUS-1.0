(() => {
    const filters = {
        normal: 'none',
        achromatomaly: 'url(#achromatomaly)',
        achromatopsia: 'url(#achromatopsia)',
        deuteranomaly: 'url(#deuteranomaly)',
        deuteranopia: 'url(#deuteranopia)',
        protanomaly: 'url(#protanomaly)',
        protanopia: 'url(#protanopia)',
        tritanomaly: 'url(#tritanomaly)',
        tritanopia: 'url(#tritanopia)',
    };

    const savedFilter = localStorage.getItem('daltonismFilter') || 'normal';

    // Aplica filtro imediatamente
    const app = document.getElementById('app');
    if (app) app.style.filter = filters[savedFilter] || 'none';

    // Função que registra listener no select
    const registerSelectListener = (select) => {
        if (!select || select.dataset.listenerRegistered) return;

        select.value = savedFilter; // garante valor inicial
        select.addEventListener('change', () => {
            const selected = select.value;
            if (app) app.style.filter = filters[selected] || 'none';
            localStorage.setItem('daltonismFilter', selected);
        });

        select.dataset.listenerRegistered = 'true'; // marca que listener já foi registrado
    };

    // Tenta registrar imediatamente
    registerSelectListener(document.getElementById('type-daltonism'));

    // Observa DOM para registrar listener se o select for renderizado depois
    const observer = new MutationObserver((mutations) => {
        for (const mutation of mutations) {
            for (const node of mutation.addedNodes) {
                if (node.nodeType === 1) {
                    if (node.id === 'type-daltonism') {
                        registerSelectListener(node);
                    } else {
                        const selectChild = node.querySelector('#type-daltonism');
                        if (selectChild) registerSelectListener(selectChild);
                    }
                }
            }
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
})();
