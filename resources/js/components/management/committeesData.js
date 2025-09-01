export function committeesData() {
    return {
        // Variáveis relacionadas ao actions-table-bar.
        showGroupCards: true,
        showCreateModal: false,
        edit: false, // O edit define se o modal vai direcionar a função para store ou update.
        expanded: false,
        showWarningModal: false,
        searchTerm: '',
        statusFilter: '',
        registerPeriod: {
            value: '',
            name: '',
            drop: false,
        },
        // Variáveis dos campos do formulário
        name: '',
        coordinator_id: '',
        members: [],
        group_id: null,
        paper_id: null,
        paper_title: null,
        member_type_id: '',
        created_at: '',
        updated_at: '',
        // Controla a visualização do input de paper
        groupSelected: false,
        // Variáveis de estado das requisições
        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningContent: '',
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
        papers: [],
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
        academicStaff: [],
        searchMember: '',
        filteredMembers: [],
        searching: false,
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

        init(committees, memberTypes, groups, academicStaff, currentPage, lastPage) {
            this.committees = committees;
            this.memberTypes = memberTypes;
            this.groups = groups;
            this.academicStaff = academicStaff;
            this.page = currentPage;
            this.totalPages = lastPage;
            this.empty = !Array.isArray(committees) || committees.length === 0;

            /*this.$watch('searchTerm', (value) => {
                if(!value) {
                    this.loadCommittees();
                }
            });*/

            this.$watch('committees', (value) => {
                this.committees.forEach(c => {
                    this.cardTypes[c.id] = 'committee';
                });
            });

            // Evento de escuta para a busca de alunos para cadastro no grupo
            this.$watch('searchMember', (value) => {
                this.searchMembers();
            });

            // Verifica
            this.$watch('group_id', () => {
                this.groupSelected = !!this.group_id;

                this.showGroupPapers();
            });

            this.$watch('searchTerm', (value) => {
                if(!value) {
                    this.loadCommittees();
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
        /*
        searchMembers() {
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(async () => {
                if (!this.showCreateModal) {
                    // Se modal fechado, cancela a busca
                    this.filteredMembers = [];
                    this.searching = false;
                    this.showNoMembersMsg = false;
                    return;
                }

                const term = this.searchMember.trim();
                if (!term) {
                    this.filteredMembers = [];
                    return;
                }

                this.searching = true;
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
                }
            }, 400); // debounce
        },*/

        searchMembers() {
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(() => {
                if (!this.showCreateModal) {
                    // Se modal fechado, cancela a busca
                    this.filteredMembers = [];
                    this.searching = false;
                    this.showNoMembersMsg = false;
                    return;
                }

                const term = this.searchMember.trim().toLowerCase();
                if (!term) {
                    this.filteredMembers = [];
                    return;
                }

                this.searching = true;
                this.showNoMembersMsg = true;

                try {
                    // Busca local no array students
                    this.filteredMembers = this.academicStaff.filter(member =>
                        (
                            member.name?.toLowerCase().includes(term) ||
                            String(member.id).toLowerCase().includes(term) // pesquisa também pelo ID
                        ) &&
                        !this.members.some(m => m.id === String(member.id)) // não repete os já adicionados
                    );
                } catch (error) {
                    console.error('Erro ao buscar professores:', error);
                } finally {
                    this.searching = false;
                }
            }, 100); // debounce
        },

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

        removeMember(userId) {
            this.members = this.members.filter(m => m.user_id !== userId);
        },

        showGroupPapers() {
            const group = this.groups.find(g => g.id === Number(this.group_id));
            if(group && group.papers) {
                this.papers = group.papers.map(p => ({
                    id: p.id,
                    title: p.title,
                    file_path: p.file_path,
                }));
            } else {
                this.papers = [];
            }
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

        async loadCommittees(page = 1) {
            this.loading = true;

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newCommittees = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter,
                    period: this.registerPeriod.value,
                }
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/committees/show`, {params});

                this.committees = response.data.data;
                console.log(response.data.data);
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

            this.name = committee.name || '';
            this.coordinator_id = committee.coordinator_id || null;
            this.group_id = committee.group_id || null;

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

            if (committee.paper) {
                // Atualiza os papers do grupo selecionado
                const group = this.groups.find(g => g.id === this.group_id);
                this.papers = group?.papers || [];

                // Agora seta o paper_id
                this.paper_id = committee.paper?.id || null;
                this.paper_title = committee.paper?.title || null;
            } else {
                this.paper_id = null;
                this.paper_title = null;
            }

            // Função para timestamps
            function formatDateTime(label, datetime, compare = null) {
                if (!datetime || (compare && datetime === compare)) return '';

                const date = new Date(datetime);
                return `${label}: ${date.toLocaleDateString('pt-BR', { year: 'numeric', month: '2-digit', day: '2-digit' })} às ${date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false })}`;
            }

            // uso:
            this.created_at = formatDateTime('Criado em', committee.created_at);
            this.updated_at = formatDateTime('Atualizado em', committee.updated_at, committee.created_at);

            this.errors = {};
            this.showBanner = false;

            this.edit = true;  // indica modo edição
            this.showCreateModal = true;
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
                    paper_id: this.paper_id,
                },
                contexto: this,
                campoLista: update ? null : 'newCommittees',
                clearFields: !update,
            });

            if(update && savedData) {
                // Função para timestamps
                function formatDateTime(label, datetime, compare = null) {
                    if (!datetime || (compare && datetime === compare)) return '';

                    const date = new Date(datetime);
                    return `${label}: ${date.toLocaleDateString('pt-BR', { year: 'numeric', month: '2-digit', day: '2-digit' })} às ${date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false })}`;
                }

                // uso:
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
                this.showWarningModal = false;
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

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
            switch (type){
                case 'store':
                    this.name = '';
                    this.coordinator_id = '';
                    this.searchMember = '';
                    this.filteredMembers = [];
                    this.members = [];
                    this.group_id = '';
                    this.paper_id = '';
                    this.member_type_id = '';
                    this.errors = {};
                    this.showBanner = false;
                    break;
                case 'filters':
                    this.searchTerm = '';
                    this.statusFilter = {};
                    this.registerPeriod = {};
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
                    this.warningContent = `Tem certeza que deseja inativar a banca ${name}?`;
                    this.committeeId = id;
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
