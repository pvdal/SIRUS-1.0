export function studentsData() {
    return {
        showCreateModal: false,
        edit: false,
        showWarningModal: false,
        searchTerm: '',
        statusFilter: '',
        registerPeriod: '',

        ra: '',
        user_id: '',
        name: '',
        email: '',
        semester: '',
        group_id: '',
        course_id: '',

        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',
        studentId: null,

        activatingIds: [],
        inactivatingIds: [],
        students: [],
        newStudents: [],
        groups: [],
        courses: [],

        loading: false,
        empty: false,
        page: 1,
        totalPages: 1,

        init(students, groups, courses,currentPage, lastPage){
            this.students = students;
            this.groups = groups;
            this.courses = courses;
            this.page = currentPage;
            this.totalPages = lastPage;

            this.empty = !Array.isArray(students) || students.length === 0;

            this.$watch('showCreateModal', (value) => {
                if(!value) {
                    this.edit = false;
                    this.studentId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
        },

        async loadStudents(page = 1) {
            this.loading = true;
            this.errors = {};
            this.newStudents = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter,
                    period: this.registerPeriod,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/students/show`, {params})

                this.students = response.data.data;
                this.groups = response.data.groups;
                this.courses = response.data.courses;
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
            this.group_id = student.group_id || '';
            this.course_id = student.course_id || '';

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        async saveStudent() {
            let url = '/students/save';
            let method = 'post';
            let id = null;

            if (this.edit && this.studentId) {
                id = this.studentId;
                url = `/students/${id}/update`;  // rota para atualizar
                method = 'put'; // 'post'/'put'/'patch' conforme backend
            }

            const savedData = await saveData({
                url: url,
                method,
                payload: {
                    ra: this.ra,
                    name: this.name,
                    email: this.email,
                    semester: this.semester,
                    group_id: this.group_id,
                    course_id: this.course_id,
                },
                contexto: this,
                campoLista: this.edit ? null : 'newStudents',
                clearFields: !this.edit,
            });

            if(this.edit && savedData) {
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

        async inactivate() {
            if (!this.studentId || this.inactivatingIds.includes(this.studentId)) return;

            const id = this.studentId;
            this.studentId = null;
            this.inactivatingIds.push(id);
            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/students/${id}/inactivate`);
                const updateState = (student) => {
                    if(student.user_id === id) {
                        student.state = 0;
                    }
                }

                this.students.forEach(updateState);
                this.newStudents.forEach(updateState);
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
                const response = await axios.put(`/${requestPrefix}/students/${id}/activate`);
                const updateState = (student) => {
                    if(student.user_id === id) {
                        student.state = 1;
                    }
                }

                this.students.forEach(updateState);
                this.newStudents.forEach(updateState);
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
                    this.ra = '';
                    this.name = '';
                    this.email = '';
                    this.semester = '';
                    this.group_id = '';
                    this.course_id = '';
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
                    this.warningContent = `Tem certeza que deseja inativar o aluno ${name}?`;
                    this.studentId = id;
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
