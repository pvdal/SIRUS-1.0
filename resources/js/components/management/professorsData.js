export function professorsData() {
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
        professorId: null,

        activatingIds: [],
        inactivatingIds: [],
        professors: [],
        newProfessors: [],

        loading: false,
        empty: false,
        page: 1,
        totalPages: 1,

        init(professors, currentPage, lastPage) {
            this.professors = professors;
            this.page = currentPage;
            this.totalPages = lastPage;

            this.empty = !Array.isArray(professors) || professors.length === 0;

            this.$watch('showCreateModal', (value) => {
                if(!value) {
                    this.edit = false;
                    this.professorId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
        },

        async loadProfessors(page = 1) {
            this.loading = true;
            this.errors = {};
            this.newProfessors = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter,
                    period: this.registerPeriod,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/professors/show`, { params });

                this.professors = response.data.data;
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

        showProfessor(id) {
            this.professorId = id;
            const professor = this.professors.find(p => p.user_id === id) || this.newProfessors.find(p => p.user_id === id);

            if (!professor) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Professor não encontrado!'
                    }
                }));
                return;
            }

            this.name = professor.name || '';
            this.email = professor.email || '';

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        async saveProfessor() {
            let url = '/professors/save';
            let method = 'post';
            let id = null;

            if (this.edit && this.professorId) {
                id = this.professorId;
                url = `/professors/${id}/update`;  // rota para atualizar
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
                campoLista: this.edit ? null : 'newProfessors',
                clearFields: !this.edit,
            });

            if(this.edit && savedData) {
                this.professors = this.professors.map(professor =>
                    professor.id === savedData.id ? savedData : professor
                );

                this.newProfessors = this.newProfessors.map(professor =>
                    professor.id === savedData.id? savedData : professor
                );
            }
        },

        isInactivating(id) {
            return this.inactivatingIds.includes(id)
        },

        async inactivate() {
            if (!this.professorId || this.inactivatingIds.includes(this.professorId)) return;

            const id = this.professorId;
            this.professorId = null;
            this.inactivatingIds.push(id);
            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response= await axios.put(`/${requestPrefix}/professors/${id}/inactivate`)
                const updateState = (professor) => {
                    if(professor.user_id === id) {
                        professor.state = 0;
                    }
                }

                this.professors.forEach(updateState);
                this.newProfessors.forEach(updateState);
            } catch (error) {
                console.error('Erro ao inativar:', error);
                const msg = error.response?.data?.message || 'Erro inesperado.';
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: msg
                    }
                }));
            } finally {
                this.inactivatingIds = this.inactivatingIds.filter(item => item !== id);
            }
        },

        isActivating(id) {
            return this.activatingIds.includes(id)
        },

        async activate(id) {
            if(!id || this.activatingIds.includes(id)) return;

            this.activatingIds.push(id);

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/professors/${id}/activate`);
                const updateState = (professor) => {
                    if(professor.user_id === id) {
                        professor.state = 1;
                    }
                }

                this.professors.forEach(updateState);
                this.newProfessors.forEach(updateState);
            } catch (error) {
                console.error('Erro ao ativar: ', error);
                const msg = error.response?.data?.message || 'Erro inesperado.'
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: msg,
                    }
                }));
            } finally {
                this.activatingIds = this.activatingIds.filter(item => item !== id);
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
                    this.warningContent = `Tem certeza que deseja inativar o professor ${name} ?`;
                    this.professorId = id;
                    break;
                case 'erro':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Ocorreu um erro ao processar a ação para o professor ${name}. Tente novamente ou contate o suporte.`;
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
