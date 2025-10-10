export function themeHandler() {
    return {
        theme: localStorage.getItem('theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),

        init() {
            this.applyTheme();
            this.$watch('theme', (value) => {
                localStorage.setItem('theme', value);
                this.applyTheme();
            });
        },

        toggleTheme() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
        },

        applyTheme() {
            if (this.theme === 'dark') {
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            }
        },
    }
}
