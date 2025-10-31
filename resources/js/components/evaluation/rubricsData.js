export function rubricsData() {
    return {
        // --- Variáveis relacionadas ao actions-table-bar ---
        showCreateModal: false,
        edit: false,// O edit define se o modal vai direcionar a função para store ou ‘update’.
        showWarningModal: false,
        searchTerm:'',
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
        searchRubric:'',

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

        // Variáveis de estado das requisições
        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',

        // Variáveis usadas para alteração de status
        rubricId: null,
        activatingIds: [],
        inactivatingIds: [],
        created_at: '',
        updated_at: '',

        // Arrays de registros do banco
        rubrics: [],
        newRubrics: [],

        // Variáveis usadas na pesquisa de eixos no modal de cadastro
        searchAxis:'',
        axes: [], // Array que vai guardar os eixos selecionados
        filteredAxes: [], // Os resultados da busca que vêm do backend
        searching: false, // Controla a mensagem "Buscando..."
        showNoAxesMsg: false,
        searchTimeout: null,
        searchAxi:'',


        rubric: {
            id: null,
            name: '',
            type: ''
        },

        // Variaveis para estado da visualização da rubrica
        showRubricCards: true,      // Controla a exibição dos cards
        showModelIframe: false,     // Controla a exibição do iframe
        modelIframeUrl: '',         // Guarda a URL para o iframe
        rubricForModelView: null,
        showModel: false,   // Boolean que exibe ou não a div da rubrica
        showModelModal: false,

        init(rubrics, page, totalPages) {
            this.rubrics = rubrics;
            this.page = page;
            this.totalPages = totalPages;
            this.empty.data = !Array.isArray(rubrics) || rubrics.length === 0;

            // Observador para a busca de eixos
            this.$watch('searchAxis', (value) => {
                value = value.trim();
                if(value) {
                    this.searchAxes();
                } else {
                    this.searching = false;
                    this.showNoAxesMsg = false;
                    this.filteredAxes = [];
                }
            });
            // Observador para limpar o formulário ao fechar o modal
            this.$watch('showCreateModal', (value) => {
                if (!value) {
                    this.edit = false;
                    this.rubricId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
        },


        async searchAxes() {
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(async () => {
                if (!this.showCreateModal) {
                    this.filteredAxes = [];
                    this.searching = false;
                    this.showNoAxesMsg = false;
                    return;
                }

                const term = this.searchAxis.trim();
                if (!term) {
                    this.filteredAxes = [];
                    this.showNoAxesMsg = false;
                    return;
                }
                this.searching = true;

                try {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    const response = await axios.get(`/${requestPrefix}/axis/search`, {
                        params: { q: term }
                    });
                    this.filteredAxes = response.data.filter(
                        eixo => !this.axes.some(sel => sel.id === eixo.id)
                    );

                    this.showNoAxesMsg = this.filteredAxes.length === 0;

                } catch (error) {
                    console.error('Erro ao buscar os eixos:', error);
                } finally {
                    this.searching = false;
                }
            }, 200); // debounce
        },

        addAxis(axis) {
            // A verificação para não adicionar duplicados está correta
            if (!this.axes.some(a => a.id === axis.id)) {

                // --- A CORREÇÃO ESTÁ AQUI ---
                // Criamos um novo objeto, garantindo que 'weight' tenha um valor inicial.
                // Pode ser um valor numérico padrão (como 1) ou uma string vazia para o usuário preencher.
                // Vamos usar '' para que o input apareça vazio.
                this.axes.push({
                    id: axis.id,
                    name: axis.name,
                    weight: '' // Inicializa o peso como uma string vazia
                });
            }
            // console.log('Eixo adicionado. Estado atual de this.axes:', JSON.stringify(this.axes, null, 2));

            // Limpa a busca para uma melhor experiência do usuário
            //this.searchAxis = '';
            //this.filteredAxes = [];
        },

        // addAxis(axis) {
        //     if (!this.axes.some(a => a.id === axis.id)) {
        //         this.axes.push({id: axis.id, name: axis.name, weight: axis.weight });
        //     }
        // },
        /**
         * Remove um eixo da lista de eixos selecionados pelo seu ID.
         */
        removeAxis(axisId) {
            this.axes = this.axes.filter(a => a.id !== axisId);
        },


        // addAxis(selectElement) {
        //     const selectedOption = selectElement.options[selectElement.selectedIndex];
        //     const eixoId = selectedOption.value;
        //
        //     // Se for a opção "Selecione...", não faz nada.
        //     if (!eixoId) return;
        //
        //     // Verifica se o eixo já não foi adicionado.
        //     const eixoJaExiste = this.eixosSelecionados.some(eixo => eixo.id == eixoId);
        //
        //     if (!eixoJaExiste) {
        //         // Adiciona o novo eixo ao array. A reatividade do Alpine cuidará de atualizar a tela!
        //         this.eixosSelecionados.push({
        //             id: eixoId,
        //             nome: selectedOption.dataset.nome,
        //             criterios: selectedOption.dataset.criterios
        //         });
        //     }
        //
        //     // Limpa o select para permitir nova seleção.
        //     selectElement.value = '';
        // },

        async loadRubrics(page = 1) {
            this.loading = true;
            this.empty.result = false;
            this.empty.data = false;

            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newRubrics = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/rubrics/show`, { params });

                // const response = await axios.get(`{/${requestPrefix}/rubrics/show`, {params});

                this.rubrics = response.data.data;
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;
                this.empty.result = !this.rubrics.length;
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
                //volta ao cursor normal
                document.body.style.cursor = 'default';
            }
        },

        get totalWeight() {
            return this.axes.reduce((sum, a) => sum + (Number(a.weight) || 0), 0);
        },

        /**
         * Função para ser chamada ao submeter o formulário.
         */
        //Save rubric com o saveData.js

        async saveRubric() {
            // Verificar se a soma dos eixos é 100%
            if (this.rubric.name && this.rubric.type && this.axes.length > 0 && this.totalWeight !== 100) {
                this.showMessage('warning', 'A soma dos pesos de todos os eixos deve ser exatamente 100%!');
                this.saving = false;
                this.errors = {}
                return;
            }

            const isUpdate = this.edit;
            let url = '/rubrics/save';
            let method = 'post';
            let id = null;
            if (isUpdate && this.rubricId) {
               id = this.rubricId;
               url = `/rubrics/${id}/update`;
               method = 'put';
           }
            // Prepara o payload como JSON
            const payload = {
                rubric_id: this .rubricId,
                name: this.rubric.name,
                type: Number(this.rubric.type),
                axes: this.axes.map(axis => ({
                    id: axis.id,
                    weight: parseFloat(axis.weight)
                }))
            };

            const savedData = await saveData({
                url,
                method,
                payload,
                contexto: this,
                campoLista: isUpdate ? null : 'newRubrics',  // só adiciona na lista se criar novo
                clearFields: !isUpdate,
            });

            if (savedData && Object.keys(savedData).length > 0) {
                this.empty.data = false;
                this.empty.result = false;
            }

            if (isUpdate && savedData) {
                this.rubrics = this.rubrics.map(a => a.id === savedData.id ? savedData : a);
                this.newRubrics = this.newRubrics.map(a => a.id === savedData.id ? savedData : a);

                // Trata os timestamps
                this.created_at = formatDateTime('Criado em', savedData.created_at);
                this.updated_at = formatDateTime('Atualizado em', savedData.updated_at, savedData.created_at);
            }
        },

        // Save rubric sem o saveData.js
        /*
        async saveRubric() {
            this.saving = true;
            this.errors = {};

            if (this.totalWeight !== 100) {
                this.showMessage('warning', 'A soma dos pesos de todos os eixos deve ser exatamente 100%!');
                this.saving = false;
                return;
            }

            const isUpdate = this.edit;

            // --- LÓGICA DE URL E PAYLOAD CORRETA ---
            const url = isUpdate ? `/rubrics/${this.rubric.id}/update` : '/rubrics/save';
            const method = isUpdate ? 'put' : 'post';
            const payload = {
                name: this.rubric.name,
                type: this.rubric.type,
                axes: this.axes.map(axis => ({
                    id: axis.id,
                    weight: parseFloat(axis.weight) || 0
                }))
            };

            // --- LÓGICA DO 'saveData' AGORA ESTÁ AQUI DENTRO ---
            try {
                // 1. Pega o prefixo da sua tag meta, como a sua função saveData fazia.
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const finalUrl = `/${requestPrefix}${url}`.replace(/\/{2,}/g, '/');

                // 2. Faz a chamada axios diretamente.
                const response = await axios({
                    method: method,
                    url: finalUrl,
                    data: payload,
                });

                // 3. Pega os dados da resposta do backend.
                const serverResponse = response.data;

                // 4. Garante que a resposta é válida.
                if (!serverResponse || !serverResponse.data) {
                    throw new Error('A resposta do servidor é inválida ou não contém dados.');
                }
                const savedRubric = serverResponse.data;

                // 5. Atualiza a interface com os novos dados.
                if (isUpdate) {
                    const index = this.rubrics.findIndex(r => r.id === savedRubric.id);
                    if (index !== -1) {
                        this.rubrics[index] = savedRubric;
                    }
                } else {
                    this.newRubrics.unshift(savedRubric);
                    this.empty = false;
                }

                // 6. Fecha o modal e mostra a mensagem de sucesso.
                this.showMessage('success', serverResponse.message);

            } catch (error) {
                // O tratamento de erro robusto.
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                    this.showMessage('danger', 'Por favor, corrija os erros no formulário.');
                } else {
                    console.error('Erro no processo de salvar:', error);
                    this.showMessage('danger', 'Ocorreu um erro inesperado ao salvar.');
                }
            } finally {
                this.saving = false;
            }
        },
        */

        showRubric(id) {
            this.rubricId = id;
            const rubric = this.rubrics.find(r => r.id === id) || this.newRubrics.find(r => r.id === id);

            if (!rubric) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Rubrica não encontrada!'
                    }
                }));
                return;
            }


            this.rubric = {
                id: rubric.id,
                name: rubric.name,
                type: rubric.type,
                // verificação de segurança para o caso de não haver eixos.
                //type: (rubric.axes && rubric.axes.length > 0) ? rubric.axes[0].type : null
            };


            if (rubric.axes && Array.isArray(rubric.axes)) {
                this.axes = rubric.axes.map(r => ({ id: r.id, name: r.name ,type: r.type, weight: r.weight}));
                //console.log("Valor do 'type' que está a ser lido:", rubric.axes[0].type);
                //console.log("A comparação `rubric.axes[0].type === 'in group'` retorna:", rubric.axes[0].type === 'in group');
            } else {
                this.axes = [];
            }

            // Trata os timestamps
            this.created_at = formatDateTime('Criado em', rubric.created_at);
            this.updated_at = formatDateTime('Atualizado em', rubric.updated_at, rubric.created_at);

            this.errors = {};
            this.showBanner = false;

            this.showCreateModal = true;
            this.edit = true;  // indica modo edição
        },


        // ===================================
        //          FUNÇÕES AUXILIARES
        // ===================================

        async toggleStatus(id = null) {
            const targetId = id ?? this.rubricId;

            const rubric = this.rubrics.find(a => a.id === targetId)
                || this.newRubrics.find(a => a.id === targetId);

            if (!rubric) return;

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(rubric.state === 1) {
                this.rubricId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/rubrics/${targetId}/${action}`);
                const updateState = (r) => {
                    if(r.id === targetId) {
                        r.state = response.data.state;
                        r.created_at = response.data.created_at;
                        r.updated_at = response.data.updated_at;
                    }
                }

                this.rubrics.forEach(updateState);
                this.newRubrics.forEach(updateState);
            } catch (error) {
                console.error('Erro ao alterar status: ', error);
                const msg = error.response?.data?.message || 'Erro inesperado.'
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: msg,
                    }
                }));
            }finally {
                this.inactivatingIds = this.inactivatingIds.filter(item => item !== targetId);
                this.activatingIds = this.activatingIds.filter(item => item !== targetId);
            }
        },

        isInactivating(id) {
            return this.inactivatingIds.includes(id);
        },

        isActivating(id) {
            return this.activatingIds.includes(id);
        },



        // clearFields(type) {
        //     clearComponentData(this, type,
        //         [
        //             'name',
        //             'search',
        //             'type',
        //             'searchAxis',
        //             'filteredAxes',
        //             'axes',
        //             'weight'
        //         ],
        //     );
        // },


        clearFields() {
            clearComponentData(
                this,           // O contexto (o próprio componente Alpine)
                'filters',      // O tipo de limpeza a ser feita
                [],             // Não há campos de formulário para limpar neste caso
                ['registerPeriod'] // Lista de filtros adicionais a serem limpos
            );
            this.rubric = {
                id: null,
                name: '',
                type: ''
            };
            this.axes = [];
            this.searchAxis = '';
            this.filteredAxes = [];
            this.created_at = '';
            this.updated_at = '';
            // this.edit = false; // o $watcher do showCreateModal já faz isso cada vez que o modal é fechado
            this.errors = {};
            // this.showBanner = false; // O próprio showMessage reseta essa variável após 3 segundos, só faz sentido manter caso queira forçar a remoção

        },

        showMessage(style, message) {
            this.style = style;
            this.message = message;
            this.showBanner = true;
            setTimeout(() => {
                this.showBanner = false;
            }, 3000);
        },

        // warning(type,id, name, rubricId, action = null) {
        //     this.warningType = 'Confirmação';
        //     this.warningContent = `Tem certeza que deseja ${action} a rúbrica "${name}"?`;
        //     this.rubric.id = rubricId; // Guarda o ID para a ação
        //     this.warningAction = action; // 'ativar' ou 'inativar'
        //     this.showWarningModal = true;
        // },

        warning(type, name, id, action=null) {
            type = type.toLowerCase();
            switch (type){
                case 'confirmação':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Tem certeza que deseja ${action} a rubrica ${name}?`;
                    this.rubricId = id;
                    this.warningAction = action;
                    break;
                case 'erro':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Ocorreu um erro ao processar a ação para a rubrica ${name}. Tente novamente ou contate o suporte.`;
                    break;
                default:
                    this.warningType = 'Aviso';
                    break;
            }
            this.showWarningModal = true;
        },


        //Função para visualização da rubrica passando por rota

        // showRubricModel(rubricId) {
        //     // Define a URL que o iframe vai carregar
        //     this.modelIframeUrl = `/rubrics/${rubricId}/model-view`;
        //
        //     // Esconde os cards e mostra a área do iframe
        //     this.showRubricCards = false;
        //     this.showModelIframe = true;
        //
        //     //    O header irá ouvir este evento.
        //     this.$dispatch('toggle-rubric-model', true);
        // },

        // agora sem passar pela rota e utilizando os dados ja enviados pelo controller
        showRubricModel(rubricId) {
            const rubricToShow = this.rubrics.find(r => r.id === rubricId) || this.newRubrics.find(r => r.id === rubricId);

            if (rubricToShow) {
                console.log(rubricToShow);
                this.rubricForModelView = rubricToShow;
                this.showRubricCards = false;
                this.showModel = true;
                // A lógica de troca de visibilidade agora é controlada pelos eventos
                this.$dispatch('toggle-rubric-model', true);
                this.$dispatch('toggle-nav-bar', false);
                // console.log('Dados para o modelo:', this.rubricForModelView);
                // console.log('JSON:', JSON.stringify(this.rubricForModelView, null, 2));

            } else {
                this.showMessage('danger', 'Não foi possível encontrar os dados do modelo da rúbrica.');
            }
        },

        hideRubricModel() {
            // Mostra os cards e esconde a área do iframe
            this.showRubricCards = true;
            this.showModelIframe = false;

            // Limpa a URL para parar o carregamento do iframe
            this.modelIframeUrl = '';
        }
    };
}
