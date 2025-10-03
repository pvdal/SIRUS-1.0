export default function eventsData() {
    return {
        showModal: false,
        showCreateModal: false,
        showEvaluationModal: false,
        edit: false,
        showWarningModal: false,
        committees: [],
        belongsTo: false,
        // Campos do formulário
        committeeId: '',
        committeeTitle: '',
        group: '',
        paper: '',
        members: [],
        timeStart: '',
        timeEnd: '',
        dateStart: '',
        dateEnd: '',
        initialDate: {
            timeStart: '',
            timeEnd: '',
            dateStart: '',
            dateEnd: '',
        },
        // Variáveis de estado das requisições
        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',

        init(committees) {
            this.committees = committees;

            window.addEventListener('open-create-modal', e => {
                if(!window.userPermissions.canManageEvents) return;

                this.showCreateModal = true;
                this.show(e,'create');
            });

            window.addEventListener('open-evaluation-modal', e => {
                this.showEvaluationModal = true;
                this.show(e,'update');
            });

            this.$watch('committeeId', (value) => {
                if(!window.userPermissions.canManageEvents || !this.showCreateModal) return;

                this.committeeTitle = '';
                this.group = '';
                this.paper = '';
                this.members = [];
                if(value) {
                    this.fillCommitteeFields(value);
                }
            });

            this.$watch('showModal', (value) => {
                if (!value) {
                    this.clearFields('create');

                    this.showEvaluationModal = false;
                    this.showCreateModal = false;
                    this.edit = false;
                }
            });
        },

        show(e,type) {
                this.$nextTick(() => {
                    if(type === 'create') {
                        this.committeeId = e.detail.id;
                    } else if(type === 'update') {
                        this.committeeId = e.detail.id;
                        this.committeeTitle = e.detail.title;
                        this.group = e.detail.group;
                        this.paper = e.detail.paper;
                        this.members = e.detail.members;

                        this.belongsTo = e.detail.members.some(m => m.belongsTo === true);
                    }
                });

            this.dateStart = e.detail.dateStart ? e.detail.dateStart.toISOString().split('T')[0] : null;
            this.dateEnd = e.detail.dateEnd ? e.detail.dateEnd.toISOString().split('T')[0] : null;
            this.timeStart = e.detail.timeStart ? e.detail.timeStart.toLocaleTimeString('pt-BR', { hour12: false }) : null;
            this.timeEnd = e.detail.timeEnd ? e.detail.timeEnd.toLocaleTimeString('pt-BR', { hour12: false }) : null;

            this.initialDate.timeStart = this.timeStart;
            this.initialDate.timeEnd = this.timeEnd;
            this.initialDate.dateStart = this.dateStart;
            this.initialDate.dateEnd = this.dateEnd;

            this.showModal = true;
        },

        fillCommitteeFields(id) {
            if(!window.userPermissions.canManageEvents) return;
            const committee = this.committees.find(c => c.id === parseInt(id, 10)); // força para número

            if(committee) {
                this.$nextTick(() => {
                    this.committeeTitle = committee.title;
                    this.group = committee.group;
                    this.paper = committee.paper;
                    this.members = committee.members;
                });
            }
        },

        async saveEvent() {
            if (!this.committeeId) {
                this.showMessage('warning', 'Nenhum evento selecionado para atualizar!');
                return;
            }

            if(!window.userPermissions.canManageEvents) return;

            let update = this.edit;
            let id = this.committeeId;

            const savedData = await saveData({
                url: `/events/${id}/update`,
                method: 'put',
                payload: {
                    dateStart: this.dateStart,
                    dateEnd: this.dateEnd,
                    timeStart: this.timeStart,
                    timeEnd: this.timeEnd,
                    create: !update,
                },
                contexto: this,
                campoLista: null,
                clearFields: !update,
            });

            window.dispatchEvent(new CustomEvent('reload-calendar', {
                detail: {
                    reload: true,
                }
            }));
        },
        //window.userPermissions.canManageEvents
        showMessage(style, message) {
            this.style = style;
            this.message = message;
            this.showBanner = true;
            setTimeout(() => {
                this.showBanner = false;
            }, 3000);
        },

        clearFields(type) {
            clearComponentData(this, type, [
                'committeeId',
                'committeeTitle',
                'group',
                'paper',
                'members',
                'timeStart',
                'timeEnd',
                'dateStart',
                'dateEnd',
            ]);

            this.timeStart = this.initialDate.timeStart ?? '';
            this.timeEnd   = this.initialDate.timeEnd ?? '';
            this.dateStart = this.initialDate.dateStart ?? '';
            this.dateEnd   = this.initialDate.dateEnd ?? '';
        }
    }
}
