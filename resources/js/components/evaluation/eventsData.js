export function eventsData() {
    return {
        showCreateModal: false,
        edit: false,
        showWarningModal: false,
        committees: '',
        // Campos do formulário
        committeeId: '',
        committeeTitle: '',
        timeStart: '',
        timeEnd: '',
        dateStart: '',
        dateEnd: '',
        allDay: false,

        init() {
            window.addEventListener('open-create-modal', e => {
                this.showCreateModal = true;

                this.committeeId = e.detail.id;
                this.committeeTitle = e.detail.title;
                this.dateStart = e.detail.dateStart ? e.detail.dateStart.toISOString().split('T')[0] : '';
                this.timeStart = e.detail.timeStart ? e.detail.timeStart.toLocaleTimeString('pt-BR', { hour12: false }) : '';
                this.dateEnd = e.detail.dateEnd ? e.detail.dateEnd.toISOString().split('T')[0] : '';
                this.timeEnd = e.detail.timeEnd ? e.detail.timeEnd.toLocaleTimeString('pt-BR', { hour12: false }) : '';

            });

            this.$watch('showCreateModal', (value) => {
                if (!value) {
                    this.committeeId = '';
                    this.committeeTitle = '';
                    this.timeStart =  '';
                    this.timeEnd =  '';
                    this.dateStart = '';
                    this.dateEnd =  '';
                    this. allDay =  false;
                }
            });
        }
    }
}
