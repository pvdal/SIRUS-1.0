<div>
    <!-- Filtros SVG -->
    <svg style="position: absolute; width: 0; height: 0;" aria-hidden="true">
        <defs>
            <!-- Acromatomalia: forma parcial de acromatopsia (sensibilidade reduzida às cores). -->
            <filter id="achromatomaly" color-interpolation-filters="linearRGB">
                <feColorMatrix type="matrix" values="
                        0.6 0.4 0.0 0 0
                        0.3 0.7 0.0 0 0
                        0.2 0.3 0.5 0 0
                        0.0 0.0 0.0 1 0"/>
            </filter>

            <!-- Achromatopsia: ausência total de percepção de cor. -->
            <filter id="achromatopsia" color-interpolation-filters="linearRGB">
                <feColorMatrix type="matrix" values="
                        0.299 0.587 0.114 0 0
                        0.299 0.587 0.114 0 0
                        0.299 0.587 0.114 0 0
                        0.000 0.000 0.000 1 0"/>
            </filter>

            <!-- Deuteranomalia: Deficiência parcial de verde -->
            <filter id="deuteranomaly" color-interpolation-filters="linearRGB">
                <feColorMatrix type="matrix" values="
                        0.620393  0.379607  0.000000  0  0
                        0.168051  0.831949  0.000000  0  0
                       -0.007092  0.025764  0.981329  0  0
                        0.000000  0.000000  0.000000  1  0"/>
            </filter>

            <!-- Deuteranopia: Deficiência de verde (cone M) - Viénot 1999 -->
            <filter id="deuteranopia" color-interpolation-filters="linearRGB">
                <feColorMatrix type="matrix" values="
                        0.367322  0.632678  0.000000  0  0
                        0.280085  0.719915  0.000000  0  0
                       -0.011820  0.042940  0.968881  0  0
                        0.000000  0.000000  0.000000  1  0"/>
            </filter>

            <!-- Protanomalia: Deficiência parcial de vermelho -->
            <filter id="protanomaly" color-interpolation-filters="linearRGB">
                <feColorMatrix type="matrix" values="
                        0.461372  0.508428  0.000000  0  0
                        0.068702  0.931098  0.000000  0  0
                       -0.002329 -0.004560  1.006889  0  0
                        0.000000  0.000000  0.000000  1  0"/>
            </filter>

            <!-- Protanopia: Deficiência de vermelho (cone L) - Viénot 1999 -->
            <filter id="protanopia" color-interpolation-filters="linearRGB">
                <feColorMatrix type="matrix" values="
                        0.152286  0.847714  0.000000  0  0
                        0.114503  0.885497  0.000000  0  0
                       -0.003882 -0.007600  1.011482  0  0
                        0.000000  0.000000  0.000000  1  0"/>
            </filter>

            <!-- Tritanomalia: Deficiência parcial de azul -->
            <filter id="tritanomaly" color-interpolation-filters="linearRGB">
                <feColorMatrix type="matrix" values="
                        1.153317 -0.153317  0.000000  0  0
                       -0.046050  1.046050  0.000000  0  0
                        0.018545  0.414820  0.566635  0  0
                        0.000000  0.000000  0.000000  1  0"/>
            </filter>

            <!-- Tritanopia: Deficiência de azul (cone S) - Viénot 1999 -->
            <filter id="tritanopia" color-interpolation-filters="linearRGB">
                <feColorMatrix type="matrix" values="
                        1.255528 -0.255528  0.000000  0  0
                       -0.076749  1.076749  0.000000  0  0
                        0.030908  0.691367  0.277725  0  0
                        0.000000  0.000000  0.000000  1  0"/>
            </filter>
        </defs>
    </svg>
</div>
