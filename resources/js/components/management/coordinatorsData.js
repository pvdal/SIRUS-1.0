export function coordinatorsData() {
    return {
        showCreateModal: false,
        edit: false,
        showWarningModal: false,
        searchTerm: '',
        statusFilter: '',
        registerPeriod: '',

        name: '',
        email: '',

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
        empty: false,
        page: 1,
        totalPages: 1,

        init(coordinators, currentPage, lastPage){
            this.coordinators = coordinators;
            this.page = currentPage;
            this.totalPages = lastPage;

            this.empty = !Array.isArray(coordinators) || coordinators.length === 0;

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
            this.errors = {};
            this.newCoordinators = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter,
                    period: this.registerPeriod,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/coordinators/show`, {params})

                this.coordinators = response.data.data;
                this.page = response.data.current_page;
                this.totalPages = response.data.last_page;

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

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        async saveCoordinator() {
            let url = '/coordinators/save';
            let method = 'post';
            let id = null;

            if (this.edit && this.coordinatorId) {
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
                },
                contexto: this,
                campoLista: this.edit ? null : 'newCoordinators',
                clearFields: !this.edit,
            });

            if(this.edit && savedData) {
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

        async inactivate() {
            if (!this.coordinatorId || this.inactivatingIds.includes(this.coordinatorId)) return;

            const id = this.coordinatorId;
            this.coordinatorId = null;
            this.inactivatingIds.push(id)
            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/coordinators/${id}/inactivate`);
                const updateState = (coordinator) => {
                    if(coordinator.user_id === id) {
                        coordinator.state = 0;
                    }
                }

                this.coordinators.forEach(updateState);
                this.newCoordinators.forEach(updateState);
            } catch (error) {
                console.error('Erro ao inativar:' . error);
                const msg = error.response?.data?.message || 'Erro inesperado.';
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: msg,
                    }
                }));
            } finally {
                this.inactivatingIds = this.inactivatingIds.filter(item => item !== id);
            }
        },

        isActivating(id) {
            return this.activatingIds.includes(id);
        },

        async activate(id) {
            if(!id || this.activatingIds.includes(id)) return;

            this.activatingIds.push(id);

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/coordinators/${id}/activate`);
                const updateState = (coordinator) => {
                    if(coordinator.user_id === id) {
                        coordinator.state = 1;
                    }
                }

                this.coordinators.forEach(updateState);
                this.newCoordinators.forEach(updateState);
            } catch (error) {
                console.error('Erro ao ativar: ', error)
                const msg = error.response?.data?.message || 'Erro inesperado.'
                window.dispatchEvent(new CustomEvent ('banner-message', {
                    detail: {
                        style: 'danger',
                        message: msg,
                    }
                }));
            } finally {
                this.activatingIds = this.activatingIds.filter(item => item !== id)
            }
        },

        clearFields(type){
            switch (type){
                case 'store':
                    this.name = '';
                    this.email = '';
                    this.errors = {};
                    break;
                case 'filters':
                    this.searchTerm = '';
                    this.statusFilter = '';
                    this.registerPeriod = '';
                    break;
                case 'warning':
                    this.warningType = '';
                    this.warningContent = '';
                    break;
                default:
                    this.clearFields('store');
                    this.clearFields('filters');
                    this.clearFields('warning')
                    break;
            }
        },

        showMessage(style, message) {
            this.style = style;
            this.message = message;
            this.showBanner = true;
            setTimeout(() => {
                this.showBanner = false;
            }, 2000);
        },

        warning(type, name, id) {
            type = type.toLowerCase();
            switch (type){
                case 'confirmação':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Tem certeza que deseja inativar o coordenador ${name}?`;
                    this.coordinatorId = id;
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
