export function coursesData(){
    return {
        showCreateModal: false,
        edit: false,
        showWarningModal: false,
        searchTerm: '',
        statusFilter: '',
        registerPeriod: '',

        name: '',
        shift: '',
        coordinator_id: '',
        created_at: '',
        updated_at: '',

        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',
        courseId: null,

        activatingIds: [],
        inactivatingIds: [],
        courses: [],
        newCourses: [],
        coordinators: [],

        loading: false,
        empty: false,
        page: 1,
        totalPages: 1,

        init(courses, coordinators, currentPage, lastPage){
            if (!Array.isArray(courses)) {
                this.courses = [];
            } else {
                this.courses = courses.map(course => ({
                    ...course,
                    shift_pt: this.translateShift(course?.shift)
                }));
            }
            this.coordinators = coordinators
            this.page = currentPage;
            this.totalPages = lastPage;

            this.empty =  this.courses.length === 0;

            this.$watch('showCreateModal', (value) => {
                if(!value) {
                    this.edit = false;
                    this.courseId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
        },

        async loadCourses(page = 1) {
            this.loading = true;
            this.errors = {};
            this.newCourses = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter,
                    period: this.registerPeriod,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/courses/show`, {params})

                if(!Array.isArray(response.data.data)) {
                    this.courses = [];
                } else {
                    this.courses = response.data.data.map(course => ({
                        ...course,
                        shift_pt: this.translateShift(course?.shift)
                    }));
                }
                this.coordinators = response.data.coordinators;
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

        translateShift(shift) {
            if (typeof shift !== 'string') {
                console.warn('Shift inválido:', shift);
                return shift ?? 'Desconhecido';
            }

            return {
                'morning': 'Manhã',
                'afternoon': 'Tarde',
                'night': 'Noite'
            }[shift.toLowerCase()] || shift;
        },

        reverseTranslateShift(shiftPt) {
            if (typeof shiftPt !== 'string') {
                console.warn('Shift inválido:', shiftPt);
                return shiftPt ?? 'unknown';
            }

            const mapping = {
                'Manh\u00E3': 'morning',
                'Tarde': 'afternoon',
                'Noite': 'night'
            };

            return mapping[shiftPt] || shiftPt;
        },

        showCourse(id) {
            this.courseId = id;
            const course = this.courses.find(c => c.id === id) || this.newCourses.find(c => c.id === id);

            if (!course) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Curso não encontrado!'
                    }
                }));
                return;
            }

            const shift = this.reverseTranslateShift(course.shift_pt);
            if (!['morning', 'afternoon', 'night'].includes(shift)) {
                this.showCreateModal = false;
                return;
            }

            this.name = course.name || '';
            this.shift = shift || '';
            this.coordinator_id = course.coordinator_id || '';

            const optionsDate = { year: 'numeric', month: '2-digit', day: '2-digit' };
            const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };

            if (course.created_at) {
                const date = new Date(course.created_at);
                const datePart = date.toLocaleDateString('pt-BR', optionsDate);
                const timePart = date.toLocaleTimeString('pt-BR', optionsTime);
                this.created_at = `Criado em: ${datePart} às ${timePart}`;
            } else {
                this.created_at = '';
            }

            if (course.updated_at && course.updated_at !== course.created_at) {
                const date = new Date(course.updated_at);
                const datePart = date.toLocaleDateString('pt-BR', optionsDate);
                const timePart = date.toLocaleTimeString('pt-BR', optionsTime);
                this.updated_at = `Atualizado em: ${datePart} às ${timePart}`;
            } else {
                this.updated_at = '';
            }

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        async saveCourse() {
            let url = '/courses/save';
            let method = 'post';
            let id = null;

            if (this.edit && this.courseId) {
                id = this.courseId;
                url = `/courses/${id}/update`;  // rota para atualizar
                method = 'put'; // 'post'/'put'/'patch' conforme backend
            }

            const savedData = await saveData({
                url: url,
                method,
                payload: {
                    name: this.name,
                    shift: this.shift,
                    coordinator_id: this.coordinator_id
                },
                contexto: this,
                campoLista: this.edit ? null : 'newCourses',
                clearFields: !this.edit,
                formatResponse: (course) => ({
                    ...course,
                    shift_pt: this.translateShift(course.shift)
                })
            });

            if(this.edit && savedData) {
                this.courses = this.courses.map(course =>
                    course.id === savedData.id ? savedData : course
                );

                this.newCourses = this.newCourses.map(course =>
                    course.id === savedData.id? savedData : course
                );
            }
        },

        isInactivating(id) {
            return this.inactivatingIds.includes(id);
        },

        async inactivate() {
            if (!this.courseId || this.inactivatingIds.includes(this.courseId)) return;

            const id = this.courseId;
            this.courseId = null;
            this.inactivatingIds.push(id);
            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/courses/${id}/inactivate`);
                const updateState = (course) => {
                    if(course.id === id) {
                        course.state = 0;
                    }
                }

                this.courses.forEach(updateState);
                this.newCourses.forEach(updateState);
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
                const response = await axios.put(`/${requestPrefix}/courses/${id}/activate`);
                const updateState = (course) => {
                    if(course.id === id) {
                        course.state = 1;
                    }
                }

                this.courses.forEach(updateState);
                this.newCourses.forEach(updateState);
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
                    this.name = '';
                    this.shift = '';
                    this.coordinator_id = '';
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
                    this.warningContent = `Tem certeza que deseja inativar o curso ${name}?`;
                    this.courseId = id;
                    break;
                case 'erro':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Ocorreu um erro ao processar a ação para o curso ${name}. Tente novamente ou contate o suporte.`;
                    break;
                default:
                    this.warningType = 'Aviso';
                    break;
            }
            this.showWarningModal = true;
        },
    }
}
