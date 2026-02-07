export function coordinatorsData() {
    return {
        showCreateModal: false,
        showImportModal: false,
        edit: false,
        showWarningModal: false,
        searchTerm: '',
        statusFilter: {
            value: '',
            name: '',
            drop: false,
        },
        registerPeriod: {
            value: '',
            name: '',
            drop: false,
        },

        name: '',
        email: '',
        education: '',
        created_at: '',
        updated_at: '',

        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',
        coordinatorId: null,

        activatingIds: [],
        inactivatingIds: [],
        coordinators: [],
        newCoordinators: [],

        loading: false,
        empty: {
            data: false,
            result: false,
        },
        get isEmpty() {
            // retorna true apenas quando quiser considerar como "vazio"
            return this.empty.result || this.empty.data;
        },
        page: 1,
        totalPages: 1,

        init(coordinators, page, totalPages){
            this.coordinators = coordinators;
            this.page = page;
            this.totalPages = totalPages;

            this.empty.data = !Array.isArray(coordinators) || coordinators.length === 0;

            this.$watch('showCreateModal', (value) => {
                if(!value) {
                    this.edit = false;
                    this.coordinatorId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
        },

        async loadCoordinators(page = 1) {
            this.loading = true;
            this.empty.result = false;
            this.empty.data = false;

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newCoordinators = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/coordinators/show`, {params})

                this.coordinators = response.data.data;
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;

                this.empty.result = !this.coordinators.length;

            } catch (error){
                if(error.response){
                    this.errors.load = error.response.data.message || 'Erro ao carregar os dados.';
                } else if (error.request){
                    this.errors.load = 'Não foi possível conectar ao servidor.';
                } else {
                    this.errors.load = 'Erro inesperado: ' + error.message;
                }
            } finally {
                this.loading = false;
                // volta o cursor ao normal
                document.body.style.cursor = 'default';
            }
        },

        showCoordinator(id) {
            this.coordinatorId = id;
            const coordinator = this.coordinators.find(c => c.user_id === id) || this.newCoordinators.find(c => c.user_id === id);

            if (!coordinator) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Coordenador não encontrado!'
                    }
                }));
                return;
            }

            this.name = coordinator.name || '';
            this.email = coordinator.email || '';

            // Trata os timestamps
            this.created_at = formatDateTime('Criado em', coordinator.created_at);
            this.updated_at = formatDateTime('Atualizado em', coordinator.updated_at, coordinator.created_at);

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        async saveCoordinator() {
            let update = this.edit;
            let url = '/coordinators/save';
            let method = 'post';
            let id = null;

            if (update && this.coordinatorId) {
                id = this.coordinatorId;
                url = `/coordinators/${id}/update`;  // rota para atualizar
                method = 'put'; // 'post'/'put'/'patch' conforme backend
            }

            const savedData = await saveData({
                url: url,
                method,
                payload: {
                    name: this.name,
                    email: this.email,
                    education: this.education,
                },
                contexto: this,
                campoLista: update ? null : 'newCoordinators',
                clearFields: !update,
            });

            if (savedData && Object.keys(savedData).length > 0) {
                this.empty.data = false;
                this.empty.result = false;
            }

            if(update && savedData) {
                // Trata os timestamps
                this.created_at = formatDateTime('Criado em', savedData.created_at);
                this.updated_at = formatDateTime('Atualizado em', savedData.updated_at, savedData.created_at);

                this.coordinators = this.coordinators.map(coordinator =>
                    coordinator.id === savedData.id ? savedData : coordinator
                );

                this.newCoordinators = this.newCoordinators.map(coordinator =>
                    coordinator.id === savedData.id? savedData : coordinator
                );
            }
        },

        isInactivating(id) {
            return this.inactivatingIds.includes(id);
        },

        isActivating(id) {
            return this.activatingIds.includes(id);
        },

        async toggleStatus(id = null) {
            const targetId = id ?? this.coordinatorId;

            const coordinator = this.coordinators.find(c => c.user_id === targetId)
                || this.newCoordinators.find(c => c.user_id === targetId);

            if (!coordinator) return;

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(coordinator.state === 1) {
                this.coordinatorId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/coordinators/${targetId}/${action}`);
                const updateState = (c) => {
                    if(c.user_id === targetId) {
                        c.state = response.data.state;
                        c.created_at = response.data.created_at;
                        c.updated_at = response.data.updated_at;
                    }
                }

                this.coordinators.forEach(updateState);
                this.newCoordinators.forEach(updateState);
            } catch (error) {
                console.error('Erro ao alterar status: ', error);
                const msg = error.response?.data?.message || 'Erro inesperado.'
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: msg,
                    }
                }));
            } finally {
                this.inactivatingIds = this.inactivatingIds.filter(item => item !== targetId);
                this.activatingIds = this.activatingIds.filter(item => item !== targetId);
            }
        },

        clearFields(type){
            clearComponentData(this,type,
                [
                    'name',
                    'email',
                    'education'
                ],
            );
        },

        showMessage(style, message) {
            this.style = style;
            this.message = message;
            this.showBanner = true;
            setTimeout(() => {
                this.showBanner = false;
            }, 2000);
        },
        warningAction: '',
        warning(type, name, id, action=null) {
            type = type.toLowerCase();
            switch (type){
                case 'confirmação':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Tem certeza que deseja ${action} o coordenador ${name}?`;
                    this.coordinatorId = id;
                    this.warningAction = action;
                    break;
                case 'erro':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Ocorreu um erro ao processar a ação para o coordenador ${name}. Tente novamente ou contate o suporte.`;
                    break;
                default:
                    this.warningType = 'Aviso';
                    this.warningContent = 'Há algo de errado! Recarregue a página e se o erro persistir contate o suporte.';
                    break;
            }
            this.showWarningModal = true;
        },
    }
}
