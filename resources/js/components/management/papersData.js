export function papersData(){
    return {
        showGroupCards: true,
        showDirectories: false,
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
        groupFilter: {
            value: '',
            name: '',
            drop: false,
        },
        versionFilter: {
            value: '',
            name: '',
            drop: false,
        },

        file_path: '',
        title: '',
        newPaperTitle: '',
        year: new Date().getFullYear(), // Ano padrão
        semester: new Date().getMonth() < 6 ? 1 : 2, // Semestre padrão
        version: 'evaluation', // Versão padrão ('evaluation' ou 'corrected')
        course_id: '',
        group_id: '',
        evaluation_paper_id: '',
        corrected_paper_id: '',
        _tempEvaluationPaperId: null,
        _tempCorrectedPaperId: null,
        project: '',
        submitted_at: '',
        corrected_version: false,
        schedule: {
            start: '',
            end: '',
        },
        created_at: '',
        updated_at: '',
        file: {
            title: '',           // Nome do arquivo
            file: null,          // Instância de File do input
            url: null,           // ObjectURL do arquivo
        },

        errors: {},
        saving: false,
        showBanner: false,
        style: '',
        message: '',
        warningType: '',
        warningAction: '',
        warningContent: '',
        paperId: null,

        activatingIds: [],
        inactivatingIds: [],
        papers: [],
        newPapers: [],
        evaluation_papers: [],
        corrected_papers: [],

        courses: [],
        groups: [],

        currentLevel: 'root', // root → year → semester → version → ...
        nav: [], // <-- array reativo que representa o caminho
        selected: {
            year: null,
            semester: null,
            version: null,
            course: null,
            project: null,
        },
        levels: ["year", "semester", "version", "course", "project"],
        action: '',
        paperOptions: {},

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
        totalPapers: 0,

        // Variáveis para visualização dos trabalhos
        showGroupPaper: false,
        paperUrl: '',
        isLoadingPdf: true,

        initialized: false,

        foldersByYear: {},
        loadingYears: [],

        init(papers,courses,groups,page,totalPages,totalItems) {
            this.papers = papers;
            this.courses = courses;
            this.groups = groups;

            this.page = page;
            this.totalPages = totalPages;
            this.totalPapers = totalItems;

            this.empty.data =  !Array.isArray(papers) || papers.length === 0;

            this.$watch('showCreateModal', (value) => {
                if(!value) {
                    this.edit = false;
                    this.paperId = null;
                    this.clearFields('store');
                    this.showBanner = false;
                    this.file = {
                        title: '',
                        file: null,
                        url: null,
                    };
                    this.year = new Date().getFullYear(); // Ano padrão
                    this.semester = new Date().getMonth() < 6 ? 1 : 2; // Semestre padrão
                    this.version = 'evaluation'; // Versão padrão ('evaluation' ou 'corrected')
                    // Limpa a referência do ‘input’ como PDF
                    this.$refs.pdfFile.value = '';
                }
            });
            // Observador reativo que garante que ao ser adicionado um arquivo no modal de update, a url seja alterada para a url do novo arquivo
            this.$watch('file.file', (newFile) => {
                this.file.title = newFile?.name ?? null;
                this.newPaperTitle = newFile?.name?.replace(/\.pdf$/i,'') ?? null;
                this.file.url = newFile ? URL.createObjectURL(newFile) : null;
            });

            this.$watch('group_id', (value) => {
                if(value) {
                    this.showGroupPapers(parseInt(value));
                } else {
                    this.evaluation_paper_id = '';
                    this.corrected_paper_id = '';
                    this._tempEvaluationPaperId = '';
                    this._tempCorrectedPaperId = '';
                    this.evaluation_papers = [];
                    this.corrected_papers = [];
                }
            })

            this.$watch('version', (value, oldValue) => {
                if (value === oldValue) return;

                // Sempre limpa o campo ativo
                this.evaluation_paper_id = '';
                this.corrected_paper_id = '';

                // Só restaura se estiver editando
                if (!this.edit) return;

                if(value === 'evaluation') {
                    this.corrected_paper_id = this._tempCorrectedPaperId;
                }
                if(value === 'corrected') {
                    this.evaluation_paper_id = this._tempEvaluationPaperId;
                }
            });
        },

        async loadYears(reload = false) {
            if (this.initialized && !reload) return;

            this.goRoot();

            this.loading = true;

            const requestPrefix =
                document.querySelector('meta[name="request-prefix"]')?.content || '';

            try {
                const { data: years } = await axios.get(`${requestPrefix}/papers/years`);

                const yearsSet = new Set(years);

                Object.keys(this.foldersByYear).forEach(year => {
                    if(!yearsSet.has(Number(year))) {
                        delete this.foldersByYear[year];
                    }
                });

                years.forEach(year => {
                    if (!this.foldersByYear[year]) {
                        this.foldersByYear[year] = {
                            loaded: false,
                            papers: [],
                            folders: null,
                        };
                    }
                });
            } catch (e) {
                console.error('Erro ao carregar anos', e);
            }

            this.loading = false;

            if (!this.initialized) {
                this.initialized = true;
            }
        },

        openYear(year) {
            if(!this.foldersByYear[year].loaded) {
                this.loadYear(year);
            }
            this.navigateTo('year',year);
        },

        get folders() {
            const result = {};
            Object.entries(this.foldersByYear).forEach(([year, data]) => {
                result[year] = data.loaded && data.folders
                    ? data.folders[year] ?? data.folders
                    : {};
            });

            return result;
        },

        get loadedPapers() {
            return Object.values(this.foldersByYear)
                .filter(year => year.loaded)
                .reduce((total, year) => total + year.papers.length, 0);
        },

        isLoadingYear(year) {
            return this.loadingYears.includes(year);
        },

        async loadYear(year) {
            if (this.foldersByYear[year]?.loaded) return;
            if (this.loadingYears.includes(year)) return;
            this.loading = true;

            this.loadingYears.push(year);

            try {
                const requestPrefix =
                    document.querySelector('meta[name="request-prefix"]')?.content || '';

                const response = await axios.get(
                    `${requestPrefix}/papers/show`,
                    { params: { year } }
                );

                const papers = Array.isArray(response.data?.data)
                    ? response.data.data
                    : Array.isArray(response.data)
                        ? response.data
                        : [];

                this.foldersByYear[year] = {
                    loaded: true,
                    papers,
                    folders: this.prepareFolders(papers),
                };

            } finally {
                this.loadingYears = this.loadingYears.filter(y => y !== year);
                this.loading = false;
            }
        },

        prepareFolders(papers) {
            const folders = {};

            papers.forEach(paper => {
                const year = paper.year ?? 'Sem ano';
                const semester = paper.semester ?? "Sem semestre";
                const version = paper.version ?? "Sem versão";
                const course = paper.course_name ?? "Sem curso";
                const project = paper.project ?? "Sem projeto";

                folders[year] ??= {};
                folders[year][semester] ??= {};
                folders[year][semester][version] ??= {};
                folders[year][semester][version][course] ??= {};
                folders[year][semester][version][course][project] ??= [];

                const arr = folders[year][semester][version][course][project];
                if (!arr.some(p => p.id === paper.id)) {
                    arr.push(paper);
                }
            });
            return this.sortFolders(folders);
        },

        sortFolders(obj) {
            const priority = ["evaluation", "corrected"];

            const sortKeys = (keys) => {
                return keys.sort((a, b) => {
                    // prioridade só vale para version
                    const ia = priority.indexOf(a);
                    const ib = priority.indexOf(b);

                    if (ia !== -1 || ib !== -1) {
                        if (ia === -1) return 1;
                        if (ib === -1) return -1;
                        return ia - ib;
                    }

                    // ordem alfabética normal
                    return a.localeCompare(b, undefined, { numeric: true });
                });
            };

            const recurse = (node) => {
                if (Array.isArray(node)) return node;

                const ordered = {};
                const keys = sortKeys(Object.keys(node));

                for (const key of keys) {
                    ordered[key] = recurse(node[key]);
                }

                return ordered;
            };

            return recurse(obj);
        },


        goRoot() {
            this.currentLevel = 'root';

            // Limpa os níveis
            for (const level of this.levels) {
                this.selected[level] = null;
            }

            // Limpa a navegação
            this.nav = [
                { label: 'Raiz', level: 'root', action: () => this.goRoot() }
            ];
        },

        navigateTo(level, value) {
            this.selected[level] = value;
            this.currentLevel = level;
            this.resetBelow(level);

            // monta breadcrumb dinamicamente
            this.nav = [
                { label: "Raiz", level: "root", action: () => this.goRoot() }
            ];

            for (const lvl of this.levels) {
                const val = this.selected[lvl];
                if (!val) break;

                let label = val;

                switch (lvl) {
                    case "semester":
                        label = `Semestre ${val}`
                        break;
                    case "version":
                        label = val === 'evaluation'
                        ? 'Avaliação'
                        :   val === 'corrected'
                            ? 'Corrigido'
                            : val
                        break;
                    case "project":
                        label = `Projeto Integrador ${val}`
                }

                this.nav.push({
                    label,
                    level: lvl,
                    action: () => this.navigateTo(lvl, val)
                });
            }
        },

        resetBelow(level) {
            const idx = this.levels.indexOf(level);

            for(let i = idx + 1; i < this.levels.length; i++ ) {
                this.selected[this.levels[i]] = null;
            }

        },

        showPaper(url) {
            // Remove overflow-hidden pra aplicar o auto e permitir scroll na página de visualização do paper
            document.body.classList.remove("overflow-hidden");
            paperViewer(this, url);
        },

        async loadPapers(page = 1) {
            this.loading = true;
            this.empty.result = false;
            this.empty.data = false;

            // muda o cursor para "aguardando"
            document.body.style.cursor = 'wait';

            this.errors = {};
            this.newPapers = [];

            try {
                const params = {
                    page,
                    search: this.searchTerm,
                    status: this.statusFilter.value,
                    period: this.registerPeriod.value,
                    group: this.groupFilter.value,
                    version: this.versionFilter.value,
                };
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.get(`/${requestPrefix}/papers/show`, {params});

                this.papers = response.data.data;
                this.page = response.data.page;
                this.totalPages = response.data.totalPages;

                this.empty.result = !this.papers.length;

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

        editPaper(id) {
            this.paperId = id;
            const paper = this.papers.find(p => p.id === id) || this.newPapers.find(p => p.id === id);

            if (!paper) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Trabalho não encontrado!'
                    }
                }));
                return;
            }

            this.file_path = paper.file_path;
            this.title = paper.title;
            this.year = paper.year;
            this.semester = paper.semester;
            this.version = paper.version;
            this.course_id = paper.course_id;
            this.group_id = paper.group_id;
            this.project = paper.project;
            this.submitted_at = paper?.submitted_at;
            this.schedule.start = paper?.scheduleDate?.start || '';
            this.schedule.end = paper?.scheduleDate?.end || '';
            this.corrected_version = paper.version === 'corrected';
            this.$nextTick(() => {
                if (this.version === 'corrected') {
                    this.evaluation_paper_id = paper.evaluation_paper_id;
                    this._tempEvaluationPaperId = this.evaluation_paper_id;
                    this.corrected_paper_id = '';
                }
                if (this.version === 'evaluation') {
                    this.evaluation_paper_id = '';
                    this.corrected_paper_id = paper.corrected_paper_id;
                    this._tempCorrectedPaperId = this.corrected_paper_id;
                }
            });
            this.created_at = paper.created_at;
            this.updated_at = paper.updated_at;

            // Trata os timestamps
            this.created_at = formatDateTime('Criado em', paper.created_at);
            this.updated_at = formatDateTime('Atualizado em', paper.updated_at, paper.created_at);

            this.errors = {};
            this.showBanner = false;

            this.edit = true;
            this.showCreateModal = true;
        },

        showGroupPapers(id) {
            this.evaluation_paper_id = '';
            this.corrected_paper_id = '';
            this.evaluation_papers = [];
            this.corrected_papers = [];
            this.papers.forEach(paper => {
                if (paper.group_id === id && paper.id !== this.paperId) {
                    if(paper.version === 'evaluation') {
                        this.evaluation_papers.push(paper);
                    }
                    if(paper.version === 'corrected') {
                        this.corrected_papers.push(paper);
                    }
                }
            })
        },

        async savePaper() {
            let update = this.edit;
            const formData = new FormData();

            formData.append('paperId', this.paperId);
            if (this.file.file) {
                formData.append('title', this.newPaperTitle ?? null);
            } else {
                formData.append('title', this.title ?? null);
            }
            if (this.file.file instanceof File) {
                formData.append('file', this.file.file);
            }
            formData.append('year', this.year ?? '');
            formData.append('semester', this.semester ?? '');
            formData.append('version', this.version ?? '');
            formData.append('course_id', this.course_id ?? '');
            formData.append('group_id', this.group_id ?? '');
            formData.append('project', this.project ?? '');
            formData.append('evaluation_paper_id', this.evaluation_paper_id ?? '');
            if (update) {
                formData.append('corrected_paper_id', this.corrected_paper_id ?? '');
            }

            let url = '/papers/save';
            let method = 'post';
            let id = null;

            if (update && this.paperId) {
                id = this.paperId;
                url = `/papers/${id}/update`;  // rota para atualizar
                formData.append('_method', 'PUT'); // 'post'/'put'/'patch' conforme backend
            }

            const savedData = await saveData({
                url,
                method,
                payload: formData,
                contexto: this,
                campoLista: update ? null : 'newPapers',
                clearFields: !update,
            });

            if (savedData.updated && Object.keys(savedData.updated).length > 0) {
                this.empty.data = false;
                this.empty.result = false;
            }

            if(update && savedData.updated) {
                const oldPaper = this.papers.find(p => p.id === savedData.updated.id) || this.newPapers.find(p => p.id === savedData.updated.id);

                // Trata os timestamps
                this.created_at = formatDateTime('Criado em', savedData.updated.created_at);
                this.updated_at = formatDateTime('Atualizado em', savedData.updated.updated_at, savedData.updated.created_at);

                this.papers = this.papers.map(paper =>
                    paper.id === savedData.updated.id ? savedData.updated : paper
                );

                this.newPapers = this.newPapers.map(paper =>
                    paper.id === savedData.updated.id? savedData.updated : paper
                );

                this.syncPaper(oldPaper, savedData.updated);

                this.file_path = savedData.updated.file_path;

                savedData.touched.forEach(touched => {
                    const oldTouched = this.papers.find(p => p.id === touched.id) || this.newPapers.find(p => p.id === touched.id);

                    this.papers = this.papers.map(p =>
                        p.id === touched.id ? touched : p
                    );

                    this.syncPaper(oldTouched, touched);
                });
                if (this.file.file) {
                    this.file.file = null;
                    this.$refs.pdfFile.value = '';
                }
            }

            if(!update && savedData) {
                this.prepareFolders(this.newPapers);
            }
        },

        syncPaper(oldPaper, newPaper) {

            const affectedYears = new Set();

            if (oldPaper?.year) affectedYears.add(oldPaper.year);
            if (newPaper?.year) affectedYears.add(newPaper.year);

            if (oldPaper?.year !== newPaper?.year) {
                this.loadYears(true);
            }

            affectedYears.forEach(year => {
                const yearData = this.foldersByYear[year];
                if (!yearData || !yearData.loaded) return;

                // remove qualquer versão antiga
                yearData.papers = yearData.papers.filter(
                    p => p.id !== newPaper.id
                );

                // reinsere se for o ano correto
                if (year === newPaper.year) {
                    yearData.papers.push(newPaper);
                }

                // reconstrói somente esse ano
                yearData.folders = this.prepareFolders(yearData.papers);
            });
        },


        isInactivating(id) {
            return this.inactivatingIds.includes(id);
        },

        isActivating(id) {
            return this.activatingIds.includes(id);
        },

        async toggleStatus(id = null) {
            const targetId = id ?? this.paperId;

            const paper = this.papers.find(p => p.id === targetId)
                || this.newPapers.find(p => p.id === targetId);

            if (!paper) {
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: 'Trabalho não encontrado!'
                    }
                }));
                return;
            }

            if (this.inactivatingIds.includes(targetId) || this.activatingIds.includes(targetId)) return;

            let action;

            if(paper.state === 1) {
                this.paperId = null;
                this.inactivatingIds.push(targetId);
                action = 'inactivate';
            } else {
                this.activatingIds.push(targetId);
                action = 'activate';
            }

            this.showWarningModal = false;

            try {
                const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                const response = await axios.put(`/${requestPrefix}/papers/${targetId}/${action}`);
                const updateState = (p) => {
                    if(p.id === targetId) {
                        p.state = response.data.state;
                        p.created_at = response.data.created_at;
                        p.updated_at = response.data.updated_at;
                    }
                }

                const touchedPaper = this.papers.find(p => p.id === targetId) || this.newPapers.find(p => p.id === targetId);

                this.papers.forEach(updateState);
                this.newPapers.forEach(updateState);

                this.syncPaper(touchedPaper,touchedPaper);
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
            this.action = 'inactivate';
        },

        clearFields(type) {
            clearComponentData(this, type,
                [
                    'title',
                    'year',
                    'semester',
                    'version',
                    'course_id',
                    'group_id',
                    'project',
                    'submitted_at',
                    'corrected_version',
                    'schedule.start',
                    'schedule.end',
                    'evaluation_paper_id',
                    'corrected_paper_id',
                    '_tempEvaluationPaperId',
                    '_tempCorrectedPaperId',
                    'file_path'
                ],
                [
                    'groupFilter',
                    'versionFilter'
                ]
            );
            // limpa buffer
            this.file = {
                title: '',
                file: null,
                url: null,
                year: new Date().getFullYear(),
                semester: new Date().getMonth() < 6 ? 1 : 2,
                project: 1,
                version: 'evaluation',
                course: null
            };
            // Limpa a referência do ‘input’ como PDF
            this.$refs.pdfFile.value = '';
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
                    this.warningContent = `Tem certeza que deseja ${action} o trabalho ${name}?`;
                    this.paperId = id;
                    this.warningAction = action;
                    break;
                case 'erro':
                    type = type.charAt(0).toUpperCase() + type.slice(1).toLowerCase();
                    this.warningType = type;
                    this.warningContent = `Ocorreu um erro ao processar a ação para o trabalho ${name}. Tente novamente ou contate o suporte.`;
                    break;
                default:
                    this.warningType = 'Aviso';
                    break;
            }
            this.showWarningModal = true;
        },

    }
}
