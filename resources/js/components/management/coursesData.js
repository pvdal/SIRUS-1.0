export function coursesData(){
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

        init(courses, coordinators, page, totalPages){
            if (!Array.isArray(courses)) {
                this.courses = [];
            } else {
                this.courses = courses.map(course => ({
                    ...course,
                    shift_pt: this.translateShift(course?.shift)
                }));
            }
            this.coordinators = coordinators
            this.page = page;
            this.totalPages = totalPages;

            this.empty.data =  !Array.isArray(courses) || courses.length === 0;

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

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newCourses = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
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
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;

                this.empty.result = !this.courses.length;

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

            // Trata os timestamps
            this.created_at = formatDateTime('Criado em', course.created_at);
            this.updated_at = formatDateTime('Atualizado em', course.updated_at, course.created_at);

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        async saveCourse() {
            let update = this.edit;
            let url = '/courses/save';
            let method = 'post';
            let id = null;

            if (update && this.courseId) {
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
                campoLista: update ? null : 'newCourses',
                clearFields: !update,
                formatResponse: (course) => ({
                    ...course,
                    shift_pt: this.translateShift(course.shift)
                })
            });

            if(update && savedData) {
                // Trata os timestamps
                this.created_at = formatDateTime('Criado em', savedData.created_at);
                this.updated_at = formatDateTime('Atualizado em', savedData.updated_at, savedData.created_at);

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

        isActivating(id) {
            return this.activatingIds.includes(id);
        },

        async toggleStatus(id = null) {
            const targetId = id ?? this.courseId;

            const course = this.courses.find(c => c.id === targetId)
                || this.newCourses.find(c => c.id === targetId);

            if (!course) return;

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(course.state === 1) {
                this.courseId = null;
                this.inactivatingIds.push(targetId);

                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/courses/${targetId}/${action}`);
                const updateState = (c) => {
                    if(c.id === targetId) {
                        c.state = response.data.state;
                        c.created_at = response.data.created_at;
                        c.updated_at = response.data.updated_at;
                    }
                }

                this.courses.forEach(updateState);
                this.newCourses.forEach(updateState);
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
                    'name',
                    'shift',
                    'coordinator_id',
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
                    this.warningContent = `Tem certeza que deseja ${action} o curso ${name}?`;
                    this.courseId = id;
                    this.warningAction = action;
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
