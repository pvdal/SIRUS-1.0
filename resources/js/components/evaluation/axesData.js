export function axesData() {
    return {
        // --- ESTADO DA INTERFACE ---
        showCreateModal: false,
        edit: false,
        showWarningModal: false,
        loading: false,
        saving: false,
        empty: {
            data: false,
            result: false,
        },
        get isEmpty() {
            // retorna true apenas quando quiser considerar como "vazio"
            return this.empty.result || this.empty.data;
        },
        searchTerm:'',

        // --- CAMPOS DE FORMULÁRIO ---
        axesId: null,
        name: '',
        created_at: '',
        updated_at: '',

        // --- BUSCA E SELEÇÃO DE CRITÉRIOS ---
        searchCriterion: '',
        filteredCriteria: [],
        selectedCriteria: [],
        searchingCriterion: false,
        searchTimeoutCriterion: null,
        showNoCriteriaMsg: false,
        statusFilter: {
            value: '',
            name: '',
            drop: false,
        },
        registerPeriod: {
            value: '',
            name: '',
            drop: false,

            personalized: false,
            startDate: '',
            endDate: '',
        },

        // --- LISTAS DE DADOS ---
        axes: [],
        newAxes: [],
        amount: '',
        page: 1,
        totalPages: 1,

        // --- ALERTAS ---
        errors: {},
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningAction: '',
        warningContent: '',
        activatingIds: [],
        inactivatingIds: [],

        /**
         * Inicializa o componente
         */
        init(axes, amount, page, totalPages) {
            this.axes = axes;
            this.amount = amount;
            this.page = page;
            this.totalPages = totalPages;
            this.empty.data = !Array.isArray(axes) || axes.length === 0;

            // Limpa ao fechar o modal
            this.$watch('showCreateModal', (value) => {
                if (!value) {
                    this.edit = false;
                    this.axesId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });

            // Monitora o campo de busca de critério
            this.$watch('searchCriterion', (value) => {
                value = value.trim();
                if (value) {
                    this.searchCriteria();
                } else {
                    this.filteredCriteria = [];
                    this.searchingCriterion = false;
                    this.showNoCriteriaMsg = false;
                }
            });
        },

        addMember(student) {
            if (!this.members.some(m => m.ra === student.ra)) {
                this.members.push({ ra: student.ra, name: student.name });
            }
        },

        async loadAxes(page = 1) {
            this.loading = true;
            this.empty.result = false;
            this.empty.data = false;

            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newAxes = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
                    personalized_start_period: this.registerPeriod.startDate,
                    personalized_end_period: this.registerPeriod.endDate,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/axis/filter`, {params});

                this.axes = response.data.data;
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;

                this.empty.result = !this.axes.length;

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

        showAxis(id) {
            this.axesId = id;
            const axis = this.axes.find(a => a.id === id) || this.newAxes.find(a => a.id === id);

            if (!axis) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Eixo não encontrado!'
                    }
                }));
                return;
            }

            // Campos do formulário
            this.name = axis.name || '';
            this.amount = axis.amount || '';
            this.selectedCriteria = axis.criteria?.map(c => ({ id: c.id, name: c.name })) || [];
            //this.selectedCriteria = axis.criteria || [];

            // Timestamps
            this.created_at = formatDateTime('Criado em', axis.created_at);
            this.updated_at = formatDateTime('Atualizado em', axis.updated_at, axis.created_at);

            this.errors = {};
            this.showBanner = false;
            this.edit = true;
            this.showCreateModal = true;

        },

        async searchCriteria() {
            if (this.searchTimeoutCriterion) clearTimeout(this.searchTimeoutCriterion);

            this.searchTimeoutCriterion = setTimeout(async () => {
                const term = this.searchCriterion.trim();
                if (!term) {
                    this.filteredCriteria = [];
                    this.showNoCriteriaMsg = false;
                    return;
                }

                this.searchingCriterion = true;
                try {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    const response = await axios.get(`/${requestPrefix}/criteria/search`, { params: { q: term } });
                    this.filteredCriteria = response.data.filter(
                        c => !this.selectedCriteria.some(sel => sel.id === c.id)
                    );
                    this.showNoCriteriaMsg = this.filteredCriteria.length === 0;
                } catch (error) {
                    console.error('Erro ao buscar critérios:', error);
                } finally {
                    this.searchingCriterion = false;
                }
            }, 200);
        },

        addCriterion(criterion) {
            if (!this.selectedCriteria.some(c => c.id === criterion.id)) {
                this.selectedCriteria.push(criterion);
            }
        },

        removeCriterion(id) {
            this.selectedCriteria = this.selectedCriteria.filter((c) => c.id !== id);
        },

        async saveAxes() {
            const isUpdate = this.edit;
            let url = '/axis/save';
            let method = 'post';

            if (isUpdate && this.axesId) {
                url = `/axis/${this.axesId}/update`;
                method = 'put';
            }

            const payload = {
                name: this.name,
                criteria: this.selectedCriteria.map(c => c.id),
            };

            const savedData = await saveData({
                url,
                method,
                payload,
                contexto: this,
                campoLista: isUpdate ? null : 'newAxes',
                clearFields: !isUpdate,
            });

            if (savedData && Object.keys(savedData).length > 0) {
                this.empty.data = false;
                this.empty.result = false;
            }

            if (savedData) {
                if (isUpdate) {
                    // CORREÇÃO: Usar savedData.id e savedData diretamente
                    this.axes = this.axes.map(a => a.id === savedData.id ? savedData : a);
                    this.newAxes = this.newAxes.map(a => a.id === savedData.id ? savedData : a);

                    // Trata os timestamps
                    this.created_at = formatDateTime('Criado em', savedData.created_at);
                    this.updated_at = formatDateTime('Atualizado em', savedData.updated_at, savedData.created_at);
                    // A definição dessas mensagens é feita pelo controller no return, chave 'message'
                    //this.showMessage('success', 'Eixo atualizado com sucesso!');
                }

                // Há um watcher que seta false pro edit automaticamente no fechamento do modal (linha 72).
                // limpeza de campos quem deve fazer é o helper saveData a partir dos campos declarados em clearComponentsData.
                // Fechar o modal logo após update não parece consistente com o resto do sistema.
                //this.showCreateModal = false;
                //this.name = '';
                //this.selectedCriteria = [];
                //this.edit = false;
            }
        },



        async updateAxis() {
            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/axis/${this.id}`, {
                    name: this.name,
                    selectedCriteria: this.selectedCriteria.map(c => c.id),
                });

                const updatedAxis = response.data.axis;

                // Atualiza os dados locais
                this.name = updatedAxis.name;
                this.amount = updatedAxis.amount;
                this.selectedCriteria = updatedAxis.criteria || [];

                // Fecha modal e atualiza lista principal se quiser
                this.showCreateModal = false;
                this.fetchAxes();

                alert(response.data.message);
            } catch (error) {
                console.error('Erro ao atualizar eixo:', error);
                alert('Erro ao atualizar o eixo.');
            }
        },

        showMessage(style, message) {
            this.style = style;
            this.message = message;
            this.showBanner = true;
            setTimeout(() => { this.showBanner = false; }, 3000);
        },

        clearFields(type) {
            clearComponentData(this, type, [
                'name',
                'axesId',
                'searchCriterion',
                'filteredCriteria',
                'selectedCriteria',
            ]);
        },

        warning(type, name, id, action=null) {
            type = type.toLowerCase();
            switch (type){
                case 'confirmação':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Tem certeza que deseja ${action} o grupo ${name}?`;
                    this.axesId = id;
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


        async toggleStatus(id = null) {
            const targetId = id ?? this.axesId;

            const axis = this.axes.find(a => a.id === targetId)
                || this.newAxes.find(a => a.id === targetId);

            if (!axis) return;

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(axis.state === 1) {
                this.axesId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/axis/${targetId}/${action}`);
                const updateState = (a) => {
                    if(a.id === targetId) {
                        a.state = response.data.state;
                        a.created_at = response.data.created_at;
                        a.updated_at = response.data.updated_at;
                    }
                }

                this.axes.forEach(updateState);
                this.newAxes.forEach(updateState);
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
    };
}
