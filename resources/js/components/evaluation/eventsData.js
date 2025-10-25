export function eventsData() {
    return {
        showModal: false,
        showCreateModal: false,
        showEvaluationModal: false,
        edit: false,
        showWarningModal: false,
        events: [],
        belongsTo: false,
        // Campos do formulário
        eventId: '',
        eventTitle: '',
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
        errors: {},
        // Variáveis de estado das requisições
        empty: {
            data: false,
            result: false,
        },
        get isEmpty() {
            // retorna true apenas quando quiser considerar como "vazio"
            return this.empty.result || this.empty.data;
        },
        saving: false,
        loading: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',

        init(events) {
            this.events = events;
            // Escuta os despachos do calendar.js para cadastro
            window.addEventListener('open-create-modal', e => {
                if(!window.userPermissions.canManageEvents) return; // Se usuário sem permissão, aborta

                this.showCreateModal = true;
                this.show(e,'create');
            });
            // Escuta os despachos do calendar.js para visualização e atualização
            window.addEventListener('open-evaluation-modal', e => {
                this.showEvaluationModal = true;
                this.show(e,'view');
            });
            // Observa o id do evento para preencher os campos reativamente com os seus dados
            this.$watch('eventId', (value) => {
                if(!window.userPermissions.canManageEvents || !this.showCreateModal) return; // Se usuário sem permissão, ou o modal ativo é de avaliação, aborta

                this.eventTitle = '';
                this.group = '';
                this.paper = '';
                this.members = [];
                if(value) {
                    this.fillCommitteeFields(value);
                }
            });
            // Reinicia os campos e estados dos modais
            this.$watch('showModal', (value) => {
                if (!value) {
                    this.clearFields('create');

                    this.showEvaluationModal = false;
                    this.showCreateModal = false;
                    this.edit = false;
                }
            });
        },
        // Mostra os eventos marcados e ainda não marcados
        show(e,type) {
            this.$nextTick(() => {
                if(type === 'create') {
                    this.eventId = e.detail.id;

                } else if(type === 'view') {
                    this.eventId = e.detail.id;
                    this.eventTitle = e.detail.title;
                    this.group = e.detail.group;
                    this.paper = e.detail.paper;
                    this.members = e.detail.members;

                    this.belongsTo = e.detail.members.some(m => m.belongsTo === true);
                }
            });

            if (type === 'create') {
                // Normaliza usando UTC -> ISO, pois vem direto do FullCalendar (select)
                this.dateStart = e.detail.dateStart
                    ? e.detail.dateStart.toISOString().split('T')[0]
                    : null;
                this.dateEnd = e.detail.dateEnd
                    ? e.detail.dateEnd.toISOString().split('T')[0]
                    : null;
            } else {
                // Mantém no fuso local, pois o eventClick já traz o datetime correto
                this.dateStart = e.detail.dateStart
                    ? e.detail.dateStart.toLocaleDateString('en-CA')
                    : null;
                this.dateEnd = e.detail.dateEnd
                    ? e.detail.dateEnd.toLocaleDateString('en-CA')
                    : null;
            }

            this.timeStart = e.detail.timeStart
                ? e.detail.timeStart.toLocaleTimeString('pt-BR', { hour12: false })
                : null;
            this.timeEnd = e.detail.timeEnd
                ? e.detail.timeEnd.toLocaleTimeString('pt-BR', { hour12: false })
                : null;

            if(type === 'create') {
                this.initialDate.timeStart = this.timeStart;
                this.initialDate.timeEnd = this.timeEnd;
                this.initialDate.dateStart = this.dateStart;
                this.initialDate.dateEnd = this.dateEnd;
            }
            this.showModal = true;
        },
        // Preenche os campos do modal
        fillCommitteeFields(id) {
            if(!window.userPermissions.canManageEvents) return;
            const committee = this.events.find(c => c.id === parseInt(id, 10)); // força para número

            if(committee) {
                this.$nextTick(() => {
                    this.eventTitle = committee.title;
                    this.group = committee.group;
                    this.paper = committee.paper;
                    this.members = committee.members;
                });
            }
        },

        async saveEvent() {
            if (!this.eventId) {
                this.showMessage('warning', 'Nenhum evento selecionado para atualizar!');
                return;
            }

            if(!window.userPermissions.canManageEvents) return;

            let update = this.edit;
            let id = this.eventId;

            const savedData = await saveData({
                url: `/events/${id}/update`,
                method: 'put',
                payload: {
                    date_start: this.dateStart,
                    date_end: this.dateEnd,
                    time_start: this.timeStart,
                    time_end: this.timeEnd,
                    create: !update,
                },
                contexto: this,
                campoLista: null,
                clearFields: !update,
            });

            if(!update && savedData?.success) {
                const filtered = this.events.filter(e => e.id !== parseInt(id, 10));
                this.events.splice(0, this.events.length, ...filtered);
            }

            window.dispatchEvent(new CustomEvent('reload-calendar', {
                detail: {
                    reload: true,
                }
            }));
        },

        async cancelEvent() {
            if (!this.eventId) {
                this.showMessage('warning', 'Nenhum evento selecionado para atualizar!');
                return;
            }

            if(!window.userPermissions.canManageEvents) return;

            let update = this.edit;
            let id = this.eventId;

            this.edit = false;
            this.eventId = '';

            const savedData = await saveData({
                url: `/events/${id}/update`,
                method: 'put',
                payload: {
                    cancel: true,
                },
                contexto: this,
                campoLista: null,
                clearFields: true,
                feedback: false,
            });
            if(savedData?.success && savedData?.events) {
                this.events.splice(0, this.events.length, ...savedData.events);

                this.showModal = false;
                window.dispatchEvent(new CustomEvent('reload-calendar', {
                    detail: {
                        reload: true,
                    }
                }));

                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'success',
                        message: savedData?.message ? savedData?.message : 'Evento cancelado com sucesso!',
                    }
                }));
            }
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
        // Limpa/reinicia os campos
        clearFields(type) {
            clearComponentData(this, type, [
                'eventId',
                'eventTitle',
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
