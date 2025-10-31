export function groupsData() {
    return {
        // Variáveis relacionadas ao actions-table-bar.
        showGroupCards: true,
        showCreateModal: false,
        edit: false, // O edit define se o modal vai direcionar a função para store ou ‘update’.
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
        // Variáveis dos campos do formulário
        theme: '',
        file: {
            title: '',           // Nome do arquivo
            file: null,          // Instância de File do input
            url: null,           // ObjectURL do arquivo
            year: new Date().getFullYear(), // Ano padrão
            semester: 1,         // Semestre padrão
            project: 1,          // Projeto padrão
            version: 'evaluation', // Versão padrão ('evaluation' ou 'corrected')
            course: '',  // ID do curso selecionado

        },
        fileObjectUrl: null,
        members: [],
        created_at: '',
        updated_at: '',
        // Variáveis de estado das requisições
        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',
        // Variáveis usadas para alteração de status
        groupId: null,
        activatingIds: [],
        inactivatingIds: [],
        // Arrays de registros do banco
        groups: [],
        newGroups: [],
        // Variáveis para visualização dos trabalhos
        showGroupPaper: false,
        paperUrl: '',
        isLoadingPdf: true,
        // Variáveis de estado das tabelas
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
        totalPage: 1,
        // Variáveis usadas na pesquisa de alunos no modal de cadastro
        students: [],
        searchStudent: '',
        filteredStudents: [],
        searching: false,
        searchTimeout: null,
        showNoStudentsMsg: false,

        papers: [], // Guarda todos os trabalhos do grupo
        paperExpanded: {}, // Controla a expansão do menu accordion
        dropAll() { // Colapsa todos os menus da array papers
            for (let key in this.paperExpanded) {
                this.paperExpanded[key] = false;
            }
        },
        courses: [], // Array de cursos para o menu de cadastro de papers
        addPaper() { // Função para adicionar ‘papers’
            if (!this.file.file || this.file.file.type !== 'application/pdf') {
                this.showMessage('warning', 'Apenas documentos PDF são permitidos!');
                return;
            }
            const newPaper = {
                id: null,
                tempId: Date.now() + Math.floor(Math.random() * 10000),

                ...this.file, // copia todos os campos do objeto
                title: this.file.title.replace(/\.pdf$/i,''),
            };
            this.papers.push(newPaper);
            this.paperExpanded[newPaper.tempId] = false;

            //console.log(this.papers[0]);
            //console.log(this.papers[0].file);
            // limpa buffer
            this.file = {
                title: '',
                file: null,
                url: null,
                year: new Date().getFullYear(),
                semester: 1,
                project: 1,
                version: 'evaluation',
                course: null
            };
            // Limpa a referência do ‘input’ como PDF
            this.$refs.pdfFile.value = '';
        },

        init(groups, courses, page, totalPages) {
            this.groups = groups;
            this.courses = courses;
            this.page = page;
            this.totalPages = totalPages;
            // Se a array vier vazia ou o objeto recebido não for array, o usuário terá como retorno que não há registros
            this.empty.data = !Array.isArray(groups) || groups.length === 0;

            // Evento de escuta para a busca de alunos para cadastro no grupo
            this.$watch('searchStudent', (value) => {
                value = value.trim();
                if(value) {
                    this.searchStudents();
                } else {
                    this.searching = false;
                    this.showNoStudentsMsg = false;
                    this.filteredStudents = [];
                }
            });

            // Garante que ao modal ser fechado o estado das variáveis de update sejam resetados, isso evita que ao fechar o modal de update o create se comporte como update
            this.$watch('showCreateModal', (value) => {
                if (!value) {
                    this.edit = false;
                    this.groupId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                    this.filteredStudents = [];
                    this.papers = [];
                    this.file = {
                        title: '',
                        file: null,
                        url: null,
                        year: new Date().getFullYear(),
                        semester: 1,
                        project: 1,
                        version: 'evaluation',
                        course: null
                    };
                }
            });
            // Observador reativo que garante que ao ser adicionado um arquivo no modal de update, a url seja alterada para a url do novo arquivo
            this.$watch('file.file', (newFile) => {
                this.file.title = newFile?.name ?? null;
                this.file.url = newFile ? URL.createObjectURL(newFile) : null;
            });
        },

        async searchStudents() {
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(async () => {
                if (!this.showCreateModal) {
                    this.filteredStudents = [];
                    this.searching = false;
                    this.showNoStudentsMsg = false;
                    return;
                }

                const term = this.searchStudent.trim();
                if (!term) {
                    this.filteredStudents = [];
                    this.showNoStudentsMsg = false;
                    return;
                }

                this.searching = true;

                try {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    const response = await axios.get(`/${requestPrefix}/students/search`, {
                        params: { q: term }
                    });


                    this.filteredStudents = response.data.filter(
                        aluno => !this.members.some(m => m.ra === aluno.ra)
                    );

                    this.showNoStudentsMsg = this.filteredStudents.length === 0;

                } catch (error) {
                    console.error('Erro ao buscar alunos:', error);
                } finally {
                    this.searching = false;
                }
            }, 200); // debounce
        },

       /*
        async searchStudents() {
            // Cancela o debounce anterior
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            const term = this.searchStudent.trim().toLowerCase();

            if (!term) {
                this.filteredStudents = [];
                this.searching = false;
                this.showNoStudentsMsg = false;
                return;
            }

            this.searching = true;

            this.searchTimeout = setTimeout(() => {
                if (!this.showCreateModal) {
                    this.filteredStudents = [];
                    this.searching = false;
                    this.showNoStudentsMsg = false;
                    return;
                }

                // Filtragem eficiente usando for loop simples
                const result = [];
                const termLower = term;

                for (let i = 0; i < this.students.length; i++) {
                    const aluno = this.students[i];

                    // Ignora alunos já membros
                    if (this.members.some(m => m.ra === aluno.ra)) continue;

                    // Checa name ou ra
                    if (aluno.name.toLowerCase().includes(termLower) || aluno.ra.toLowerCase().includes(termLower)) {
                        result.push(aluno);
                    }
                }

                this.filteredStudents = result;
                this.searching = false;
                this.showNoStudentsMsg = result.length === 0;
            }, 400);
        },*/

        addMember(student) {
            if (!this.members.some(m => m.ra === student.ra)) {
                this.members.push({ ra: student.ra, name: student.name });
            }
        },

        removeMember(ra) {
            this.members = this.members.filter(m => m.ra !== ra);
        },

        showPaper(url) {
            // Remove overflow-hidden pra aplicar o auto e permitir scroll na página de visualização do paper
            document.body.classList.remove("overflow-hidden");
            paperViewer(this, url);
        },

        async loadGroups(page = 1) {
            this.loading = true;
            this.empty.result = false;
            this.empty.data = false;

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newGroups = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
                }
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/groups/show`, {params});

                this.groups = response.data.data;
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;

                this.empty.result = !this.groups.length;
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
                // volta o cursor ao normal
                document.body.style.cursor = 'default';
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
                this.papers = group.papers.map(p => ({
                    id: p.id,
                    title: p.title,
                    file_path: p.file_path,
                    year: p.year,
                    semester: p.semester,
                    project: p.project,
                    version: p.version,
                    course: p.course,
                    state: p.state,
                }));
                // Inicializa paperExpanded
                this.paperExpanded = {}; // garante que está vazio
                this.papers.forEach(p => {
                    const key = p.id ?? p.tempId;
                    this.paperExpanded[key] = false;
                });
                //const paper = group.papers[0];
                //this.file = { name: paper.title.split('/').pop(), url: paper.file_path };
            } else {
                //this.file = null;
                this.papers = [];
                this.paperExpanded = {};
            }

            // Trata os timestamps
            this.created_at = formatDateTime('Criado em', group.created_at);
            this.updated_at = formatDateTime('Atualizado em', group.updated_at, group.created_at);

            this.errors = {};
            this.showBanner = false;

            this.showCreateModal = true;
            this.edit = true;  // indica modo edição
        },

        removePaper(paperId) {
            const paperToRemove = this.papers.find(p => p.id === paperId || p.tempId === paperId);

            if(paperToRemove?.url) {
                URL.revokeObjectURL(paperToRemove.url);
            }

            this.papers = this.papers.filter(p => p.id !== paperId && p.tempId !== paperId)
        },

        async saveGroup() {
            let update = this.edit;
            const formData = new FormData();
            formData.append('theme', this.theme);

            if (this.papers.length > 0) {
                this.papers.forEach((p, index) => {
                    formData.append(`papers[${index}][id]`, p.id ?? null);
                    formData.append(`papers[${index}][title]`, p.title ?? '');
                    if (p.file instanceof File) {
                        formData.append(`papers[${index}][file]`, p.file);
                    }
                    formData.append(`papers[${index}][year]`, p.year ?? '');
                    formData.append(`papers[${index}][semester]`, p.semester ?? '');
                    formData.append(`papers[${index}][version]`, p.version ?? '');
                    formData.append(`papers[${index}][course]`, p.course ?? '');
                    formData.append(`papers[${index}][project]`, p.project ?? '');
                });
            }

            //console.log(this.papers);
            //console.log(formData);

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

            if (update && this.groupId) {
                id = this.groupId;
                url = `/groups/${id}/update`;  // rota para atualizar
                formData.append('_method', 'PUT'); // ou 'put'/'patch' conforme backend
            }

            const newMembers = this.members;
            const groupTheme = this.theme;

            const savedData = await saveData({
                url,
                method,
                payload: formData,
                contexto: this,
                campoLista: update ? null : 'newGroups',  // só adiciona na lista se criar novo
                clearFields: !update,
            });

            const beforeMembers = this.students.filter(s => s.group === groupTheme);
            const afterMembers = newMembers;

            this.students = this.students.map(student => {
               const stillInGroup = afterMembers.find(s => s.ra === student.ra);

               if (stillInGroup) {
                   return {
                       ...student,
                       group: groupTheme
                   }
               }

               if (beforeMembers.find(s => s.ra === student.ra)) {
                   return {
                       ...student,
                       group: null
                   }
               }

               return student;
            });

            if (savedData && Object.keys(savedData).length > 0) {
                this.empty.data = false;
                this.empty.result = false;
            }

            // Alteração dos dados nas arrays locais, de acordo com o update do controller
            if(update && savedData) {
                this.papers.forEach(p => {
                    if (p.file?.url) {
                        URL.revokeObjectURL(p.file.url);
                    }
                });

                // Substitui pelos papers retornados do backend, já sem campos temporários
                this.papers = (savedData.papers ?? []).map(p => ({
                    ...p,
                    file: undefined,
                    tempId: undefined
                }));

                // Trata os timestamps
                this.created_at = formatDateTime('Criado em', savedData.created_at);
                this.updated_at = formatDateTime('Atualizado em', savedData.updated_at, savedData.created_at);

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

        isActivating(id) {
            return this.activatingIds.includes(id);
        },

        async toggleStatus(id = null) {
            const targetId = id ?? this.groupId;

            const group = this.groups.find(g => g.id === targetId)
                || this.newGroups.find(g => g.id === targetId);

            if (!group) return;

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(group.state === 1) {
                this.groupId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/groups/${targetId}/${action}`);
                const updateState = (g) => {
                    if(g.id === targetId) {
                        g.state = response.data.state;
                        g.created_at = response.data.created_at;
                        g.updated_at = response.data.updated_at;
                    }
                }

                this.groups.forEach(updateState);
                this.newGroups.forEach(updateState);
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

        clearFields(type) {
            clearComponentData(this, type,
                [
                    'theme',
                    'searchStudent',
                    'filteredStudents',
                    'members',
                    'papers'
                ],
            );
        },

        showMessage(style, message) {
            this.style = style;
            this.message = message;
            this.showBanner = true;
            setTimeout(() => {
                this.showBanner = false;
            }, 3000);
        },

        warningAction: '',

        warning(type, name, id, action=null) {
            type = type.toLowerCase();
            switch (type){
                case 'confirmação':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Tem certeza que deseja ${action} o grupo ${name}?`;
                    this.groupId = id;
                    this.warningAction = action;
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
