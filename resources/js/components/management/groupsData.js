export function groupsData() {
    return {
        // Variáveis relacionadas ao actions-table-bar.
        showGroupCards: true,
        showCreateModal: false,
        edit: false, // O edit define se o modal vai direcionar a função para store ou update.
        showWarningModal: false,
        searchTerm: '',
        statusFilter: '',
        registerPeriod: '',
        // Variáveis dos campos do formulário
        theme: '',
        file: null,
        fileObjectUrl: null,
        members: [],
        // Variáveis de estado das requisições
        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',
        // Variáveis que armazenam coleção de registros e preparam alteração de estado (ativo/inativo) o update
        groupId: null,
        activatingIds: [],
        inactivatingIds: [],
        groups: [],
        newGroups: [],
        // Variáveis para visualização dos trabalhos
        showGroupPaper: false,
        paperUrl: '',
        isLoadingPdf: true,
        // Variáveis de estado das tabelas
        loading: false,
        empty: false,
        page: 1,
        totalPage: 1,
        // Variáveis usadas na pesquisa de alunos no modal de cadastro
        searchStudent: '',
        filteredStudents: [],
        searching: false,
        searchTimeout: null,
        showNoStudentsMsg: false,

        init(groups, currentPage, lastPage) {
            this.groups = groups;
            this.page = currentPage;
            this.totalPages = lastPage;
            // Se a array vier vazia ou o objeto recebido não for array, o usuário terá como retorno que não há registros
            this.empty = !Array.isArray(groups) || groups.length === 0;
            // Evento de escuta para a busca de alunos para cadastro no grupo
            this.$watch('searchStudent', (value) => {
                this.searchStudents();
            });
            // Garante que ao modal ser fechado o estado das variáveis de update sejam resetados, isso evita que ao fechar o modal de update o create se comporte como update
            this.$watch('showCreateModal', (value) => {
                if (!value) {
                    this.edit = false;
                    this.groupId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
            // Observador reativo que garante que ao ser adicionado um arquivo no modal de update, a url seja alterada para a url do novo arquivo
            this.$watch('file', (newFile, oldFile) => {
                if (this.fileObjectUrl) {
                    URL.revokeObjectURL(this.fileObjectUrl);
                    this.fileObjectUrl = null;
                }
                if (newFile instanceof File) {
                    this.fileObjectUrl = URL.createObjectURL(newFile);
                }
            });
        },

        async searchStudents() {
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(async () => {
                if (!this.showCreateModal) {
                    // Se modal fechado, cancela a busca
                    this.filteredStudents = [];
                    this.searching = false;
                    this.showNoStudentsMsg = false;
                    return;
                }

                const term = this.searchStudent.trim();
                if (!term) {
                    this.filteredStudents = [];
                    return;
                }

                this.searching = true;
                this.showNoStudentsMsg = true;
                try {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    const response = await axios.get(`/${requestPrefix}/students/search`, {
                        params: { q: term }
                    });
                    // Filtra alunos que ainda não estão na lista de membros
                    this.filteredStudents = response.data.filter(aluno =>
                        !this.members.some(m => m.ra === aluno.ra)
                    );

                    console.log(this.filteredStudents);
                } catch (error) {
                    console.error('Erro ao buscar alunos:', error);
                } finally {
                    this.searching = false;
                }
            }, 400); // debounce
        },

        addMember(aluno) {
            if (!this.members.some(m => m.ra === aluno.ra)) {
                this.members.push({ ra: aluno.ra, name: aluno.name });
            }
        },

        removeMember(ra) {
            this.members = this.members.filter(m => m.ra !== ra);
        },

        showPaper(url) {
            this.showGroupCards = false;
            this.isLoadingPdf = true;
            this.paperUrl = url;
            this.showGroupPaper = true;
            this.$dispatch('toggle-paper', true);
            this.$nextTick(() => {
                setTimeout(() => {
                    this.paperUrl = url;
                    this.showGroupPaper = true;
                    this.$dispatch('toggle-paper', true);
                }, 10);
            });
        },

        async loadGroups(page = 1) {
            this.loading = true;
            this.errors = {};
            this.newGroups = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter,
                    period: this.registerPeriod,
                }
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/groups/list`, {params});

                this.groups = response.data.data;
                this.page = response.data.current_page;
                this.totalPages = response.data.last_page;
            } catch (error) {
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

        showGroup(id) {
            this.groupId = id;
            const group = this.groups.find(g => g.id === id) || this.newGroups.find(g => g.id === id);

            if (!group) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Grupo não encontrado!'
                    }
                }));
                return;
            }

            this.theme = group.theme || '';

            if (group.students && Array.isArray(group.students)) {
                this.members = group.students.map(s => ({ ra: s.ra, name: s.name }));
            } else {
                this.members = [];
            }

            // Pega o nome do arquivo, se existir
            if (group.papers && group.papers.length > 0) {
                const paper = group.papers[0];
                this.file = { name: paper.title.split('/').pop(), url: paper.file_path };
            } else {
                this.file = null;
            }
            this.errors = {};
            this.showBanner = false;

            this.showCreateModal = true;
            this.edit = true;  // indica modo edição
        },

        async saveGroup() {
            const formData = new FormData();
            formData.append('theme', this.theme);

            if (this.file instanceof File) {
                formData.append('file', this.file);
            }

            if (this.members.length === 0) {
                formData.append('members[]', '');
            } else {
                this.members.forEach(m => {
                    formData.append('members[]', m.ra);
                });
            }

            let url = '/groups/save';        // rota padrão para criar
            let method = 'post';
            let id = null;

            if (this.edit && this.groupId) {
                id = this.groupId;
                url = `/groups/${id}/update`;  // rota para atualizar
                formData.append('_method', 'PUT'); // ou 'put'/'patch' conforme backend
            }

            const savedData = await saveData({
                url,
                method,
                payload: formData,
                contexto: this,
                clearFields: !this.edit,
                campoLista: this.edit ? null : 'newGroups',  // só adiciona na lista se criar novo
            });

            if(this.edit && savedData) {
                this.groups = this.groups.map(group =>
                    group.id === savedData.id ? savedData : group
                );

                this.newGroups = this.newGroups.map(group =>
                    group.id === savedData.id? savedData : group
                );
            }
        },

        isInactivating(id) {
            return this.inactivatingIds.includes(id);
        },

        async inactivate() {
            if (!this.groupId || this.inactivatingIds.includes(this.groupId)) return;

            const id = this.groupId;
            this.groupId = null;
            this.inactivatingIds.push(id);
            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/groups/${id}/inactivate`);
                const updateState = (group) => {
                    if(group.id === id) {
                        group.state = 0;
                    }
                }

                this.groups.forEach(updateState);
                this.newGroups.forEach(updateState);
            } catch (error) {
                console.error('Erro ao inativar: ', error);
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
            return this.activatingIds.includes(id);
        },

        async activate(id) {
            if (!id || this.activatingIds.includes(id)) return;

            this.activatingIds.push(id);

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/groups/${id}/activate`);
                const updateState = (group) => {
                    if(group.id === id) {
                        group.state = 1;
                    }
                }

                this.groups.forEach(updateState);
                this.newGroups.forEach(updateState);
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

        clearFields(type) {
            switch (type){
                case 'store':
                    this.theme = '';
                    this.file = '';
                    this.searchStudent = '';
                    this.filteredStudents = [];
                    this.members = [];
                    this.errors = {};
                    this.showBanner = false;
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
            }, 3000);
        },

        warning(type,name,id) {
            type = type.toLowerCase();
            switch (type){
                case 'confirmação':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Tem certeza que deseja inativar o grupo ${name}?`;
                    this.groupId = id;
                    break;
                case 'erro':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Ocorreu um erro ao processar a ação para o grupo ${name}. Tente novamente ou contate o suporte.`;
                    break;
                default:
                    this.warningType = 'Aviso';
                    break;
            }
            this.showWarningModal = true;
        },
    }
}
