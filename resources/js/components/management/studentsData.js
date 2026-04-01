export function studentsData() {
    return {
        // Variáveis relacionadas ao actions-table-bar
        showCreateModal: false,
        showImportModal: false,
        edit: false, // O edit define se o modal vai direcionar a função para store ou ‘update’
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
        groupFilter: {
            id:'',
            search: '',
            theme:'',
            drop: false,
        },
        courseFilter: {
            id: '',
            name: '',
            drop: false,
        },
        // Variáveis dos campos do formulário
        ra: '',
        user_id: '',
        name: '',
        email: '',
        semester: '',
        group: {
            id: '',
            theme: '',
            drop: false,
            search: '',
        },
        course_id: '',
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
        studentId: null,
        activatingIds: [],
        inactivatingIds: [],
        // Arrays de registros do banco
        students: [],
        newStudents: [],

        groups: [],
        searching: false,
        showNoGroupsMsg: false,

        courses: [],
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
        totalPages: 1,
        // perPage: 12, // teste de paginação js

        // paginação php
        init(students, groups, courses, page, totalPages){
            this.students = students;
            this.groups = groups;
            this.courses = courses;
            this.page = page;
            this.totalPages = totalPages;

            this.empty.data = !Array.isArray(students) || students.length === 0;

            this.$watch('groupFilter.search', (value) => {
                value = value.trim();
                if(value) {
                    this.searchGroups();
                } else {
                    this.searching = false;
                    this.showNoGroupsMsg = false;

                }
            });

            this.$watch('group.search', (value) => {
                console.log('chegou');
                value = value.trim();
                if(value) {
                    this.searchGroups();
                } else {
                    this.searching = false;
                    this.showNoGroupsMsg = false;

                }
            });

            this.$watch('showCreateModal', (value) => {
                if(!value) {
                    this.edit = false;
                    this.studentId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
        },

        async searchGroups() {
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(async () => {
                if (!this.groupFilter.drop && !this.group.drop ) {
                    this.searching = false;
                    this.showNoGroupsMsg = false;
                    return;
                }

                const term = this.groupFilter.search.trim() || this.group.search.trim();
                if (!term) {
                    this.searching = false;
                    this.showNoGroupsMsg = false;
                    return;
                }

                this.searching = true;

                try {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    const response = await axios.get(`/${requestPrefix}/groups/search`, {
                        params: { q: term }
                    });


                    this.groups = response.data.filter(
                        group => this.groupFilter.id !== group.id
                    );

                    this.showNoGroupsMsg = this.groups.length === 0;

                } catch (error) {
                    console.error('Erro ao buscar grupos:', error);
                } finally {
                    this.searching = false;
                }
            }, 200); // debounce
        },

        async loadStudents(page = 1) {
            this.loading = true;
            this.empty.result = false;
            this.empty.data = false;

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newStudents = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
                    course: this.courseFilter.id,
                    group: this.groupFilter.id,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/students/show`, {params})

                this.students = response.data.data;
                this.groups = response.data.groups;
                this.courses = response.data.courses;
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;

                this.empty.result = !this.students.length;

                // Paginação local (.js)
                //this.page = 1;               // página inicial
                //this.perPage = 15;           // itens por página
                //this.totalPages = Math.ceil(this.students.length / this.perPage);

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

        showStudent(id) {
            this.studentId = id;
            const student = this.students.find(s => s.user_id === id) || this.newStudents.find(s => s.user_id === id);

            if (!student) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Aluno não encontrado!'
                    }
                }));
                return;
            }

            this.ra = student.ra || '';
            this.user_id = student.user_id || '';
            this.name = student.name || '';
            this.email = student.email || '';
            this.semester = student.semester || '';
            this.group.id = student.group.id || '';
            this.group.theme = student.group.name || '';
            this.course_id = student.course.id || '';

            // Trata os timestamps
            this.created_at = formatDateTime('Criado em', student.created_at);
            this.updated_at = formatDateTime('Atualizado em', student.updated_at, student.created_at);

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        async saveStudent() {
            let update = this.edit;
            let url = '/students/save';
            let method = 'post';
            let id = null;

            if (update && this.studentId) {
                id = this.studentId;
                url = `/students/${id}/update`;  // rota para atualizar
                method = 'put'; // 'post'/'put'/'patch' conforme backend
            }

            const savedData = await saveData({
                url: url,
                method,
                payload: {
                    ra: this.ra ? this.ra.toString().replace(/\D/g, '') : null,
                    name: this.name,
                    email: this.email,
                    group_id: this.group.id,
                    course_id: this.course_id,
                },
                contexto: this,
                campoLista: update ? null : 'newStudents',
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

                this.students = this.students.map(student =>
                    student.ra === savedData.ra ? savedData : student
                );

                this.newStudents = this.newStudents.map(student =>
                    student.ra === savedData.ra? savedData : student
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
            const targetId = id ?? this.studentId;
            const student = [...this.students, ...this.newStudents].find(s => s.user_id === targetId);
            if (!student) return;

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(student.state === 1) {
                this.studentId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/students/${targetId}/${action}`);
                const updateState = (s) => {
                    if(s.user_id === targetId) {
                        s.state = response.data.state;
                        s.created_at = response.data.created_at;
                        s.updated_at = response.data.updated_at;
                    }
                }

                this.students.forEach(updateState);
                this.newStudents.forEach(updateState);
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
            clearComponentData(this,type,
                [
                    'ra',
                    'name',
                    'email',
                    'course_id',
                ],
                [
                    'groupFilter',
                    'courseFilter',
                ],
            );
            this.filteredGroups = [];
            this.group = {
                id: '',
                theme: '',
                drop: false,
                search: '',
            };
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
                    this.warningContent = `Tem certeza que deseja ${action} o aluno ${name}?`;
                    this.studentId = id;
                    this.warningAction = action;
                    break;
                case 'erro':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Ocorreu um erro ao processar a ação para o aluno ${name}. Tente novamente ou contate o suporte.`;
                    break;
                default:
                    this.warningType = 'Aviso';
                    break;
            }
            this.showWarningModal = true;
        },
    }
}
