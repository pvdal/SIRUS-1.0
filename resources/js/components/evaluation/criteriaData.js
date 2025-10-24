export function criteriaData() {
    return {
        // Variáveis do actions-table-bar
        showCreateModal: false,
        edit: false, // Define se o modal vai para store ou update
        showWarningModal: false,
        searchTerm: '',
        statusFilter: {
            value: '',
            name: '',
            drop: false
        },
        registerPeriod: {
            value: '',
            name: '',
            drop: false
        },

        // Variáveis dos campos do formulário de Critério
        criterionId: null,
        id: '',
        name: '',
        excellent: '',
        good: '',
        satisfactory: '',
        unsatisfactory: '',
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

        // Variáveis para alteração de status
        activatingIds: [],
        inactivatingIds: [],

        // Arrays de registros
        criteria: [],
        newCriteria: [],

        // Variáveis de estado da tabela
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

        // Inicialização do componente
        init(criteria, page, totalPages) {
            this.criteria = criteria;
            this.page = page;
            this.totalPages = totalPages;
            this.empty.data = !Array.isArray(criteria) || criteria.length === 0;

            // Limpa o formulário e reseta o estado quando o modal é fechado
            this.$watch('showCreateModal', (value) => {
                if (!value) {
                    this.edit = false;
                    this.criterionId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
        },

        // Preenche o modal com os dados de um critério para edição
        showCriterion(criterion) {
            if (!criterion) {
                console.error('Critério não encontrado!');
                return;
            }

            this.criterionId = criterion.id;
            this.name = criterion.name || '';
            this.unsatisfactory = criterion.unsatisfactory || '';
            this.satisfactory = criterion.satisfactory || '';
            this.good = criterion.good || '';
            this.excellent = criterion.excellent || '';
            this.created_at = formatDateTime('Criado em', criterion.created_at);
            this.updated_at = formatDateTime('Atualizado em', criterion.updated_at, criterion.created_at);

            this.errors = {};
            this.showBanner = false;
            this.edit = true;
            this.showCreateModal = true;
        },
        //Filtro de busca
        async loadCriteria(page = 1) {
            this.loading = true;
            this.empty.result = false;
            this.empty.data = false;

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newCriteria = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,

                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/criteria/show`, {params})

                this.criteria = response.data.data;
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;

                this.empty.result = !this.criteria.length;
            }
            catch (error){
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

        // Salva um critério novo ou atualiza um existente
        async saveCriterion() {
            const isUpdate = this.edit;
            let url = '/criteria/save';
            let method = 'post';
            let id = null;

            if (isUpdate && this.criterionId) {
                id = this.criterionId;
                url = `/criteria/${id}/update`; // Rota para atualizar
                method = 'put';
            }

            const savedData = await saveData({
                url: url,
                method,
                payload: {
                    name: this.name,
                    unsatisfactory: this.unsatisfactory,
                    satisfactory: this.satisfactory,
                    good: this.good,
                    excellent: this.excellent,
                },
                contexto: this,
                campoLista: isUpdate ? null : 'newCriteria', // Adiciona na lista de 'novos' se for cadastro
                clearFields: !isUpdate, // Limpa os campos se for cadastro
            });

            if (savedData && Object.keys(savedData).length > 0) {
                this.empty.data = false;
                this.empty.result = false;
            }

            if (isUpdate && savedData) {
                // Atualiza os timestamps no modal
                this.created_at = formatDateTime('Criado em', savedData.created_at);
                this.updated_at = formatDateTime('Atualizado em', savedData.updated_at, savedData.created_at);

                // Atualiza o critério na lista principal e na de novos
                const updateItem = (item) => (item.id === savedData.id ? savedData : item);
                this.criteria = this.criteria.map(updateItem);
                this.newCriteria = this.newCriteria.map(updateItem);
            }
        },



        // Funções para controlar o estado dos botões de ativar/inativar
        isInactivating(id) {
            return this.inactivatingIds.includes(id);
        },
        isActivating(id) {
            return this.activatingIds.includes(id);
        },

        // Alterna o status (ativo/inativo) de um critério
        async toggleStatus(id = null) {
            const targetId = id ?? this.criterionId;
            const criterion = [...this.criteria, ...this.newCriteria].find(c => c.id === targetId);
            if (!criterion) return;

            if (this.isInactivating(targetId) || this.isActivating(targetId)) return;

            let action;

            if(criterion.state === 1) {
                this.criterionId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }


            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                // Rota para alternar o status
                const response = await axios.put(`/${requestPrefix}/criteria/${targetId}/${action}`);

                // Atualiza o estado do critério em ambas as listas
                const updateState = (c) => {
                    if (c.id === targetId) {
                        c.state = response.data.state;
                        c.updated_at = response.data.updated_at;
                    }
                };
                this.criteria.forEach(updateState);
                this.newCriteria.forEach(updateState);

            } catch (error) {
                console.error('Erro ao alterar status:', error);
            } finally {
                // Remove o ID da lista de "carregando"
                this.inactivatingIds = this.inactivatingIds.filter(item => item !== targetId);
                this.activatingIds = this.activatingIds.filter(item => item !== targetId);
            }
        },

        // Limpa campos do formulário ou filtros
        clearFields(type) {
            clearComponentData(this, type, [
                'name',
                'unsatisfactory',
                'satisfactory',
                'good',
                'excellent',

            ], );
        },

        showMessage(style, message) {
            this.style = style;
            this.message = message;
            this.showBanner = true;
            setTimeout(() => {
                this.showBanner = false;
            }, 3000);
        },
        // Exibe o modal de aviso/confirmação
        warningAction: '',
        warning(type, name, id, action = null) {
            type = type.toLowerCase();
            this.warningType = type.charAt(0).toUpperCase() + type.slice(1);

            if (type === 'confirmação') {
                this.warningContent = `Tem certeza que deseja ${action} o critério ${name}?`;
                this.criterionId = id;
                this.warningAction = action.charAt(0).toUpperCase() + action.slice(1);;
            } else if (type === 'erro') {
                this.warningContent = `Ocorreu um erro ao processar a ação para o critério ${name}.`;
            }
            this.showWarningModal = true;
        },
    }
}
