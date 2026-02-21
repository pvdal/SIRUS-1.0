export function eventsData() {
    return {
        showModal: false,
        showCreateModal: false,
        showEvaluationModal: false,
        showEvaluationForm: false,
        edit: false,
        filters: false,
        searchTerm: '',
        courseFilter: {
            value: '',
            name: '',
            drop: false,
        },
        projectFilter: {
            value: '',
            name: '',
            drop: false,
        },

        showWarningModal: false,
        events: [],
        courses: [],
        belongsTo: false,
        evaluatedByUser: false,
        // Campos do formulário
        eventId: '',
        eventTitle: '',
        group: '',
        paper: '',
        committeeMembers: [],
        groupMembers: [],
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
        loadingData: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',

        //Variável para uso da rubrica
        userCommitteeId: null,

        init(events,courses) {
            this.events = events;
            this.courses = courses;
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
            // Escuta os despachos do calendar.js para desativar as animações de carregamento
            window.addEventListener('calendar-loading', (e) => {
                this.loadingData = e.detail.loading;
            });

            // Observa o id do evento para preencher os campos reativamente com os seus dados
            this.$watch('eventId', (value) => {
                if(!window.userPermissions.canManageEvents || !this.showCreateModal) return; // Se usuário sem permissão, ou o modal ativo é de avaliação, aborta

                this.eventTitle = '';
                this.group = '';
                this.paper = '';
                this.committeeMembers = [];
                this.groupMembers = [];
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
                    this.committeeMembers = e.detail.committeeMembers;
                    this.groupMembers = e.detail.groupMembers;

                    this.belongsTo = e.detail.belongsTo === true;
                    this.evaluatedByUser = e.detail.evaluatedByUser === true;

                    /*
                    const currentUserMember = e.detail.committeeMembers.find(m => m.belongsTo === true);
                    //console.log("caiu aqui",currentUserMember);

                    this.userCommitteeId = null;
                    if (currentUserMember) {
                        this.belongsTo = true;

                        // Pegamos o ID da tabela pivo (user_committees)
                        // **PONTO DE ATENÇÃO**: Verifique se o nome da propriedade é 'user_committee_id'
                        // Pode ser 'id', 'pivot_id', etc., dependendo de como seu backend envia.
                        this.userCommitteeId = currentUserMember.user_committee_id;

                    } else {
                        this.belongsTo = false;
                    }
                    */
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
                    this.committeeMembers = committee.committeeMembers;
                    this.groupMembers = committee.groupMembers;
                });
            }
        },

        async loadEvents() {
            console.log(this.searchTerm);
            window.dispatchEvent(new CustomEvent('reload-calendar', {
                detail: {
                    reload: true,
                    search: this.searchTerm,
                    course: this.courseFilter.id,
                    project: this.projectFilter.id,
                }
            }));
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
                    'committeeMembers',
                    'groupMembers',
                    'timeStart',
                    'timeEnd',
                    'dateStart',
                    'dateEnd',
                ],
                [
                    'courseFilter',
                    'projectFilter',
                ]
            );

            this.timeStart = this.initialDate.timeStart ?? '';
            this.timeEnd   = this.initialDate.timeEnd ?? '';
            this.dateStart = this.initialDate.dateStart ?? '';
            this.dateEnd   = this.initialDate.dateEnd ?? '';
        },

        //função para esconder o modal de detalhes e mostrar a tela de avaliação

        // openEvaluationForm() {
        //     if (this.eventId) {
        //         this.showEvaluationModal = false; // Esconde o modal de detalhes
        //         this.showModal = false;
        //         this.showEvaluationForm = true;   // Mostra o formulário de avaliação
        //
        //         // Dispara um evento global para que o componente de avaliação saiba qual evento carregar
        //         window.dispatchEvent(new CustomEvent('start-evaluation', {
        //             detail: {
        //                 eventId: this.eventId
        //             }
        //         }));
        //     }
        // },

        openEvaluationForm() {
            // this.eventId é o committee_id
            if (this.eventId) {

                // Constrói a URL para a rota que os Gates entendem
                const evaluationUrl = `/evaluation/${this.eventId}`;

                // Redireciona para rota
                window.location.href = evaluationUrl;

            } else {
                alert("Erro: Não foi possível encontrar o ID da Banca (CommitteeID).");
            }
        },
    }
}
