const app = document.getElementById('app');

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
function applyFilter() {
    const select = document.getElementById('type-daltonism');
    if (!app || !select) return false;

    const savedFilter = localStorage.getItem('daltonismFilter') || 'normal';
    app.style.filter = filters[savedFilter] || 'none';
    select.value = savedFilter;

    select.addEventListener('change', () => {
        const selected = select.value;
        app.style.filter = filters[selected] || 'none';
        localStorage.setItem('daltonismFilter', selected);
    });

    return true;
}

// Tenta aplicar o filtro imediatamente, e se não der, tenta novamente a cada 50ms
if (!applyFilter()) {
    const interval = setInterval(() => {
        if (applyFilter()) clearInterval(interval);
    }, 50);
}
