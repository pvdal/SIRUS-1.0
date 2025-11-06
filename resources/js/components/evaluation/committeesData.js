export function committeesData() {
    return {
        // Variáveis de modais
        showGroupCards: true,
        showCreateModal: false,
        edit: false, // O edit define se o modal vai direcionar a função para store ou update.
        showWarningModal: false,
        // Variáveis relacionadas ao actions-table-bar.
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
        historyFilter: false,
        toggleHistory(){
            this.$dispatch('toggle-history', this.historyFilter);
        },
        // Variáveis dos campos do formulário
        name: '',
        coordinator_id: '',
        showingCommittee: false,
        group_id: null,
        groupSelected: false,// Controla a visualização do input de paper
        paper_id: {
            evaluation: null,
            corrected: false,
        },
        paper_title: null,
        rubric_id: {
            group: null,
            individual: null,
        },
        members: [],
        member_type_id: '',
        created_at: '',
        updated_at: '',
        belongsTo: false,
        evaluatedByUser: false,
        // Variáveis de estado das requisições
        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',
        warningAction: '',
        // Variáveis que armazenam coleção de registros e preparam alteração de estado (ativo/inativo) o update
        committeeId: null,
        activatingIds: [],
        inactivatingIds: [],
        committees: [],
        newCommittees: [],
        coordinators: [],
        professors: [],
        memberTypes: [],
        groups: [],
        papers: {
            evaluation: [],
            corrected: [],
        },
        rubrics: [],
        // Variáveis para visualização dos trabalhos
        selectedVersion: {},
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
        // Variáveis usadas na pesquisa de membros e rubricas no modal de cadastro
        academicStaff: [],
        searchMember: '',
        filteredMembers: [],
        searching: false,
        searchingMembers: false,
        searchRubric: '',
        filteredRubrics: [],
        showNoRubricsMsg: false,
        searchingRubrics: false,
        searchTimeout: null,
        showNoMembersMsg: false,
        // Altera o modo do card
        cardTypes: {},
        setCardType(id,type) {
            this.cardTypes[id] = type;
        },
        getCardType(id) {
            return this.cardTypes[id] || 'committee';
        },
        setAllCardType(type) {
            for(let id in this.cardTypes) {
                this.cardTypes[id] = type;
            }
        },
        hasGroupCard() {
            return Object.values(this.cardTypes).includes('group');
        },
        hasCommitteeCard() {
            return Object.values(this.cardTypes).includes('committee');
        },

        expanded: false,

        init(committees, memberTypes, groups, academicStaff, page, totalPages) {
            this.committees = committees;
            this.memberTypes = memberTypes;
            this.groups = groups;
            this.academicStaff = academicStaff;
            this.page = page;
            this.totalPages = totalPages;
            this.empty.data = !Array.isArray(committees) || committees.length === 0;

            this.$watch('committees', () => {
                this.committees.forEach(c => {
                    this.cardTypes[c.id] = 'committee';
                });
                this.committees.forEach(c => {
                    this.selectedVersion[c.id] = 'evaluation';
                });
            });

            // Evento de escuta para a busca de alunos para cadastro no grupo
            this.$watch('searchMember', () => {
                this.searchMembers();
            });

            // Evento de escuta para a busca de rubricas para cadastro no grupo
            this.$watch('searchRubric', () => {
                this.searchRubrics();
            });

            // Mostra os papers de cada grupo selecionado
            this.$watch('group_id', () => {
                this.groupSelected = !!this.group_id;
                this.showGroupPapers();
                // Reseta o valor de paper_id caso o usuário efetue um clique diferente de alterar (visualizar)
                if(!this.showingCommittee) {
                    this.paper_id.evaluation = null;
                    this.paper_id.corrected = null;
                }
            });
            // Garante que ao modal ser fechado o estado das variáveis de update sejam resetados, isso evita que ao fechar o modal de update o create se comporte como update
            this.$watch('showCreateModal', (value) => {
                if (!value) {
                    this.edit = false;
                    this.committeeId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                }
            });
        },

        searchRubrics() {
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(async () => {
                if (!this.showCreateModal) {
                    // Se modal fechado, cancela a busca
                    this.filteredRubrics = [];
                    this.searching = false;
                    this.searchingRubrics = false;
                    this.showNoRubricsMsg = false;
                    return;
                }

                const term = this.searchRubric.trim();
                if (!term) {
                    this.filteredRubrics = [];
                    this.showNoRubricsMsg = false;
                    return;
                }

                this.searching = true;
                this.searchingRubrics = false;
                this.showNoRubricsMsg = true;
                try {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    const response = await axios.get(`/${requestPrefix}/rubrics/search`, {
                        params: { q: term }
                    });
                    // Filtra membros que ainda não estão na lista de membros
                    this.filteredRubrics = response.data.filter(member =>
                        !this.rubrics.some(m => m.id === member.id)
                    );
                } catch (error) {
                    console.error('Erro ao buscar professores:', error);
                } finally {
                    this.searching = false;
                    this.searchingRubrics = false;
                }
            }, 200); // debounce
        },

        addRubric(rubric) {
            if (!this.rubrics.some(r => r.id === rubric.id)) {
                this.rubrics.push({ id: rubric.id, name: rubric.name, type: rubric.type });
            }
        },

        removeRubric(id) {
            this.rubrics = this.rubrics.filter(r => r.id !== id);
        },

        get totalWeight() {
            return this.rubrics.reduce((sum, r) => sum + (Number(r.weight) || 0), 0);
        },

        searchMembers() {
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(async () => {
                if (!this.showCreateModal) {
                    // Se modal fechado, cancela a busca
                    this.filteredMembers = [];
                    this.searching = false;
                    this.searchingMembers = false;
                    this.showNoMembersMsg = false;
                    return;
                }

                const term = this.searchMember.trim();
                if (!term) {
                    this.filteredMembers = [];
                    this.showNoMembersMsg = false;
                    return;
                }

                this.searching = true;
                this.searchingMembers = false;
                this.showNoMembersMsg = true;
                try {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    const response = await axios.get(`/${requestPrefix}/members/search`, {
                        params: { q: term }
                    });
                    // Filtra membros que ainda não estão na lista de membros
                    this.filteredMembers = response.data.filter(member =>
                        !this.members.some(m => m.id === member.id)
                    );
                } catch (error) {
                    console.error('Erro ao buscar professores:', error);
                } finally {
                    this.searching = false;
                    this.searchingMembers = false;
                }
            }, 200); // debounce
        },

        // Adiciona membros
        addMember(member) {
            if (!this.member_type_id) {
                alert('Selecione o tipo de membro antes de adicionar.');
                return;
            }

            // pegar o objeto completo do tipo de membro
            const selectedType = this.memberTypes.find(mt => mt.id === Number(this.member_type_id));

            if (!this.members.some(m => m.user_id === member.user_id)) {
                this.members.push({ id: member.id, user_id: member.user_id, name: member.name,
                    user_type: {
                        id: member.user_type.id,
                        name: member.user_type.name,
                    },
                    member_type: {
                        id: selectedType.id,
                        name: selectedType.name
                    } });
            }
        },
        // Remove membros
        removeMember(userId) {
            this.members = this.members.filter(m => m.user_id !== userId);
        },

        // Mantém a lista de papers atualizada
        showGroupPapers() {
            const group = this.groups.find(g => g.id === Number(this.group_id));
            if(group && group.papers) {
                this.papers.evaluation = group.papers
                    .filter(p => p.version === 'evaluation')
                    .map(p => ({
                        id: p.id,
                        title: p.title,
                        file_path: p.file_path,
                        version: p.version,
                    }));

                this.papers.corrected = group.papers
                    .filter(p => p.version === 'corrected')
                    .map(p => ({
                        id: p.id,
                        title: p.title,
                        file_path: p.file_path,
                        version: p.version,
                    }));
            } else {
                this.papers.evaluation = [];
            }
        },

        // Mostra o trabalho do aluno
        showPaper(url) {
            paperViewer(this, url);
        },

        async loadCommittees(page = 1) {
            this.loading = true;
            this.empty.result = false;
            this.empty.data = false;

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newCommittees = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
                    history: this.historyFilter,
                }
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/committees/show`, {params});

                this.committees = response.data.data;
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;

                this.empty.result = !this.committees.length;
                this.toggleHistory();
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

        showCommittee(id) {
            this.committeeId = id;
            const committee = this.committees.find(c => c.id === id) || this.newCommittees.find(c => c.id === id);

            if (!committee) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Banca não encontrada!'
                    }
                }));
                return;
            }

            this.showingCommittee = true;
            this.name = committee.name || '';
            this.coordinator_id = committee.coordinator_id || null;
            this.group_id = committee.group_id || null;

            if (committee.rubrics && Array.isArray(committee.rubrics)) {
                this.rubrics = committee.rubrics.map(r => ({
                    id: r.id,
                    name: r.name,
                    type: r.type,
                    weight: r.weight,
                    state: r.state ?? 1
                }));
            } else {
                this.members = [];
            }

            if (committee.members && Array.isArray(committee.members)) {
                this.members = committee.members.map(m => ({
                    user_id: m.user_id,
                    name: m.name,
                    member_type: { id: m.member_type?.id, name: m.member_type?.name },
                    user_type: { ...m.user_type },
                    state: m.state ?? 1
                }));
            } else {
                this.members = [];
            }

            if (committee.paper.evaluation) {

                // Seta o paper_id
                this.$nextTick(() => {
                    this.paper_id.evaluation = committee.paper?.evaluation?.id || null;
                });
                this.paper_title = committee.paper?.evaluation?.title || null;
            } else {
                this.paper_id.evaluation = null;
                this.paper_title = null;
            }

            if (committee.paper.corrected) {
                // Seta o paper_id
                this.$nextTick(() => {
                    this.paper_id.corrected = committee.paper?.corrected?.id || null;
                });
                this.paper_title = committee.paper?.corrected?.title || null;
            } else {
                this.paper_id.corrected = null;
                this.paper_title = null;
            }

            this.belongsTo = committee.belongsTo === true;
            this.evaluatedByUser = committee.evaluatedByUser === true;

            // Trata os timestamps
            this.created_at = formatDateTime('Criado em', committee.created_at);
            this.updated_at = formatDateTime('Atualizado em', committee.updated_at, committee.created_at);

            this.errors = {};
            this.showBanner = false;

            this.edit = true;  // indica modo edição
            this.showCreateModal = true;

            // Garante que a função de anular o paper_id seja funcional apenas após o usuário setar outro grupo no modo edição.
            // o nextTick seria um clique diferente do efetuado agora, 'alterar'
            this.$nextTick(() => {
                this.showingCommittee = false;
            });
        },

        async saveCommittee() {
            let update = this.edit;
            let url = '/committees/save';
            let method = 'post';
            let id = null;

            if (update && this.committeeId) {
                id = this.committeeId;
                url = `/committees/${id}/update`;  // rota para atualizar
                method = 'put'; // 'post'/'put'/'patch' conforme backend
            }

            const savedData = await saveData({
                url: url,
                method,
                payload: {
                    name: this.name,
                    members: this.members,
                    group_id: this.group_id,
                    paper_id: this.paper_id.evaluation,
                    corrected_paper_id: this.paper_id.corrected ? Number(this.paper_id.corrected) : null,
                    rubrics: this.rubrics,
                },
                contexto: this,
                campoLista: update ? null : 'newCommittees',
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

                this.committees = this.committees.map(committee =>
                    committee.id === savedData.id ? savedData : committee
                );

                this.newCommittees = this.newCommittees.map(committee =>
                    committee.id === savedData.id? savedData : committee
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
            const targetId = id ?? this.committeeId;

            const committee = this.committees.find(c => c.id === targetId)
                || this.newCommittees.find(c => c.id === targetId);

            if (!committee) return;

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(committee.state === 1) {
                this.committeeId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/committees/${targetId}/${action}`);
                const updateState = (c) => {
                    if(c.id === targetId) {
                        c.state = response.data.state;
                        c.created_at = response.data.created_at;
                        c.updated_at = response.data.updated_at;
                    }
                }

                this.committees.forEach(updateState);
                this.newCommittees.forEach(updateState);
            } catch (error) {
                console.error('Erro ao alterar status: ', error);
                const msg = error.response?.data?.message || 'Erro inesperado.';

                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: (error.response?.data?.success === false && msg) ? msg : 'Erro inesperado!',
                    }
                }));
            } finally {
                this.inactivatingIds = this.inactivatingIds.filter(item => item !== targetId);
                this.activatingIds = this.activatingIds.filter(item => item !== targetId);
            }
        },

        openEvaluationForm(id) {
            if (this.committeeId || id) {
                // Constrói a URL
                window.location.href = `/evaluation/${this.committeeId || id}`;
            } else {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Não foi possível encontrar o ID da Banca.',
                    }
                }))
            }
        },

        clearFields(type) {
            clearComponentData(this, type,
                [
                    'name',
                    'coordinator_id',
                    'searchMember',
                    'filteredMembers',
                    'members',
                    'searchRubric',
                    'filteredRubrics',
                    'rubrics',
                    'group_id',
                    'paper_id.evaluation',
                    'paper_id.corrected',
                    'member_type_id',
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

        warning(type, name, id, action=null) {
            type = type.toLowerCase();
            switch (type){
                case 'confirmação':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Tem certeza que deseja ${action} a banca ${name}?`;
                    this.committeeId = id;
                    this.warningAction = action;
                    break;
                case 'erro':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Ocorreu um erro ao processar a ação para a banca ${name}. Tente novamente ou contate o suporte.`;
                    break;
                default:
                    this.warningType = 'Aviso';
                    break;
            }
            this.showWarningModal = true;
        },
    }
}
