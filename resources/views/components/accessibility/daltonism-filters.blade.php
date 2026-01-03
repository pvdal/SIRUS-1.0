    <div>
        <!-- Filtros SVG -->
        <svg style="position: absolute; width: 0; height: 0;" aria-hidden="true">
            <defs>
                <!-- Acromatomalia: forma parcial de acromatopsia (sensibilidade reduzida às cores). -->
                <filter id="achromatomaly" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="
                            0.618 0.320 0.062 0 0
                            0.163 0.775 0.062 0 0
                            0.163 0.320 0.516 0 0
                            0.000 0.000 0.000 1 0"/>
                </filter>

                <!-- Achromatopsia: ausência total de percepção de cor. -->
                <filter id="achromatopsia" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="
                            0.299 0.587 0.114 0 0
                            0.299 0.587 0.114 0 0
                            0.299 0.587 0.114 0 0
                            0.000 0.000 0.000 1 0"/>
                </filter>

                <!-- Deuteranomalia: Deficiência parcial de verde -->
                <filter id="deuteranomaly" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="
                            0.618 0.320 0.062 0 0
                            0.163 0.775 0.062 0 0
                            0.163 0.320 0.516 0 0
                            0.000 0.000 0.000 1 0"/>
                </filter>

                <!-- Deuteranopia: Deficiência de verde (cone M) -->
                <filter id="deuteranopia" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="
                            0.625 0.375 0.000 0 0
                            0.700 0.300 0.000 0 0
                            0.000 0.300 0.700 0 0
                            0.000 0.000 0.000 1 0"/>
                </filter>

                <!-- Protanomalia: Deficiência parcial de vermelho -->
                <filter id="protanomaly" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="
                            0.817 0.183 0.000 0 0
                            0.333 0.667 0.000 0 0
                            0.000 0.125 0.875 0 0
                            0.000 0.000 0.000 1 0"/>
                </filter>

                <!-- Protanopia: Deficiência de vermelho (cone L) -->
                <filter id="protanopia" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="
                            0.567 0.433 0.000 0 0
                            0.558 0.442 0.000 0 0
                            0.000 0.242 0.758 0 0
                            0.000 0.000 0.000 1 0"/>
                </filter>

                <!-- Tritanomalia: Deficiência parcial de azul -->
                <filter id="tritanomaly" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="
                            0.967 0.033 0.000 0 0
                            0.000 0.733 0.267 0 0
                            0.000 0.183 0.817 0 0
                            0.000 0.000 0.000 1 0"/>
                </filter>

                <!-- Tritanopia: Deficiência de azul (cone S) -->
                <filter id="tritanopia" color-interpolation-filters="sRGB">
                    <feColorMatrix type="matrix" values="
                            0.950 0.050 0.000 0 0
                            0.000 0.433 0.567 0 0
                            0.000 0.475 0.525 0 0
                            0.000 0.000 0.000 1 0"/>
                </filter>
            </defs>
        </svg>
    </div>
