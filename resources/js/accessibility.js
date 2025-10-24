(() => {
    const daltonism = localStorage.getItem('daltonism') === 'true';

    // Aplica classe global logo no início (antes de renderizar a página)
    if (daltonism) {
        document.documentElement.classList.add('daltonism-enabled');
    }

    // Aguarda o DOM para injetar o seletor e filtros
    document.addEventListener('DOMContentLoaded', () => {
        if (!daltonism) return;

        // --- SVG com filtros ---
        const svgFilters = `
                    <svg style="position:absolute;width:0;height:0;" aria-hidden="true">
                        <defs>
                            <filter id="achromatomaly" color-interpolation-filters="linearRGB">
                                <feColorMatrix type="matrix" values="
                                    0.6 0.4 0.0 0 0
                                    0.3 0.7 0.0 0 0
                                    0.2 0.3 0.5 0 0
                                    0.0 0.0 0.0 1 0"/>
                            </filter>

                            <filter id="achromatopsia" color-interpolation-filters="linearRGB">
                                <feColorMatrix type="matrix" values="
                                    0.299 0.587 0.114 0 0
                                    0.299 0.587 0.114 0 0
                                    0.299 0.587 0.114 0 0
                                    0.000 0.000 0.000 1 0"/>
                            </filter>

                            <filter id="deuteranopia" color-interpolation-filters="linearRGB">
                                <feColorMatrix type="matrix" values="
                                    0.367322  0.632678  0.000000  0  0
                                    0.280085  0.719915  0.000000  0  0
                                   -0.011820  0.042940  0.968881  0  0
                                    0.000000  0.000000  0.000000  1  0"/>
                            </filter>

                            <filter id="protanopia" color-interpolation-filters="linearRGB">
                                <feColorMatrix type="matrix" values="
                                    0.152286  0.847714  0.000000  0  0
                                    0.114503  0.885497  0.000000  0  0
                                   -0.003882 -0.007600  1.011482  0  0
                                    0.000000  0.000000  0.000000  1  0"/>
                            </filter>

                            <filter id="tritanopia" color-interpolation-filters="linearRGB">
                                <feColorMatrix type="matrix" values="
                                    1.255528 -0.255528  0.000000  0  0
                                   -0.076749  1.076749  0.000000  0  0
                                    0.030908  0.691367  0.277725  0  0
                                    0.000000  0.000000  0.000000  1  0"/>
                            </filter>
                        </defs>
                    </svg>
                `;
        document.body.insertAdjacentHTML('afterbegin', svgFilters);

        // --- UI do seletor ---
        const filterBox = `
                    <div class="fixed bottom-2 left-2 bg-white px-4 py-[14px] rounded-lg border border-gray-200 shadow-md min-w-[215px] z-10">
                        <div class="flex items-center gap-2 mb-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="text-gray-600 shrink-0">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <label for="type-daltonism"
                                   class="text-[12px] font-medium text-gray-600 uppercase tracking-[0.5px]">
                                Filtros de daltonismo
                            </label>
                        </div>

                        <select id="type-daltonism"
                            class="block w-full border-2 border-gray-300 rounded-md p-1.5 focus:border-blue-400 focus:ring-blue-400">
                            <option value="normal">Normal</option>
                            <option value="achromatomaly">Acromatomalia</option>
                            <option value="achromatopsia">Acromatopsia</option>
                            <option value="deuteranopia">Deuteranopia</option>
                            <option value="protanopia">Protanopia</option>
                            <option value="tritanopia">Tritanopia</option>
                        </select>
                    </div>
                `;
        document.body.insertAdjacentHTML('beforeend', filterBox);

        // --- Aplica os filtros dinamicamente ---
        const app = document.getElementById('app');
        const select = document.getElementById('type-daltonism');

        if (!app || !select) return;

        const filters = {
            normal: 'none',
            achromatomaly: 'url(#achromatomaly)',
            achromatopsia: 'url(#achromatopsia)',
            deuteranopia: 'url(#deuteranopia)',
            protanopia: 'url(#protanopia)',
            tritanopia: 'url(#tritanopia)',
        };

        select.addEventListener('change', () => {
            app.style.filter = filters[select.value] || 'none';
        });
    });
})();
