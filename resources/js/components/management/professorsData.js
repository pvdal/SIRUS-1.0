export function professorsData() {
    return {
        showCreateModal: false,
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
        created_at: '',
        updated_at: '',

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

            /*this.$watch('searchTerm', (value) => {
                if(!value) {
                    this.loadProfessors();
                }
            });*/

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

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newProfessors = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
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
                // volta o cursor ao normal
                document.body.style.cursor = 'default';
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

            // Trata os timestamps
            this.created_at = formatDateTime('Criado em', professor.created_at);
            this.updated_at = formatDateTime('Atualizado em', professor.updated_at, professor.created_at);

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        async saveProfessor() {
            let update = this.edit;
            let url = '/professors/save';
            let method = 'post';
            let id = null;

            if (update && this.professorId) {
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
                campoLista: update ? null : 'newProfessors',
                clearFields: !update,
            });

            if(update && savedData) {
                // Trata os timestamps
                this.created_at = formatDateTime('Criado em', savedData.created_at);
                this.updated_at = formatDateTime('Atualizado em', savedData.updated_at, savedData.created_at);

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

        isActivating(id) {
            return this.activatingIds.includes(id)
        },

        async toggleStatus(id = null) {
            const targetId = id ?? this.professorId;

            const professor = this.professors.find(p => p.user_id === targetId)
                || this.newProfessors.find(p => p.user_id === targetId);

            if (!professor) return;

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(professor.state === 1) {
                this.professorId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/professors/${targetId}/${action}`);
                const updateState = (p) => {
                    if(p.user_id === targetId) {
                        p.state = response.data.state;
                        p.created_at = response.data.created_at;
                        p.updated_at = response.data.updated_at;
                    }
                }

                this.professors.forEach(updateState);
                this.newProfessors.forEach(updateState);
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
                    this.warningContent = `Tem certeza que deseja ${action} o professor ${name} ?`;
                    this.professorId = id;
                    this.warningAction = action;
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
