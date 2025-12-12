export function daltonismFilters(){
    return {
        showDaltonismIcon: false,
        open: false,
        showFilters: false,
        showPositionMenu: false,

        position: 'middle-right',
        vlibrasEnabled: false,
        teste: 'top-1/2 translate-y-[80%] left-[10px]',

        init() {
            if (localStorage.getItem('daltonism_enabled') === null) {
                localStorage.setItem('daltonism_enabled', 'true');
            }
            this.position = 'middle-right';
            this.showDaltonismIcon = localStorage.getItem('daltonism_enabled') === 'true';
            this.vlibrasEnabled = localStorage.getItem('vlibras_enabled') === 'true';

            window.addEventListener('toggle-vlibras', () => {
                this.vlibrasEnabled = localStorage.getItem('vlibras_enabled') === 'true';
            })
        },

        get positions() {
            const addBottom = this.vlibrasEnabled ? '-translate-y-[140%]' : '';
            return {
                'top-left': {btn: 'top-[74px] left-[10px]', menu: 'left-0 top-full mt-2', nav: 'left-[3.1rem]'},
                'top-right': {btn: 'top-[74px] right-[10px]', menu: 'right-0 top-full mt-2', nav: 'right-[3.1rem]'},

                'middle-left': {btn: 'top-1/2 translate-y-[80%] left-[10px]', menu: 'left-0 top-full mt-2', nav: 'left-[3.1rem]'},
                'middle-right': {btn: 'top-1/2 translate-y-[80%] right-[10px]', menu: 'right-0 top-full mt-2', nav: 'right-[3.1rem]'},

                'bottom-left': {btn: `bottom-[10px] ${addBottom} left-[10px]`, menu: 'left-0 bottom-full mb-2', nav: 'left-[3.1rem]'},
                'bottom-right': {btn: `bottom-[10px] ${addBottom} right-[10px]`, menu: 'right-0 bottom-full mb-2', nav: 'right-[3.1rem]'}
            };
        },
        get pos() {
            this.vlibrasEnabled; // Dependência reativa, quando esse valor muda as posições são redefinidas
            return this.positions[this.position];
        },
    }
}
