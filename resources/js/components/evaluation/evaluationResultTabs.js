export function evaluationResultTabs(initialData) {
    return {
        ...initialData,
        consolidatedResults: [],
        activeTabIndex:0,

        groupSelections: {},
        individualSelections: {},

        // Variaveis para comentarios
        showCommentModal: false,
        currentCommentText: '',
        currentCommentTarget: {
            axisType: null, // 'group' ou 'individual'
            criterionId: null,
            studentId: null // 'RA001' (apenas para individual)
        },
        isCommentReadOnly: true,
        showHelp: false,

        // Marcação de tempo
        lap: {
            group: initialData.presentation_time ?? null,
            committee: initialData.evaluation_time ?? null,
        },
        format(t) {
            let m = Math.floor(t / 60);
            let s = t % 60;
            return `${m}:${s.toString().padStart(2,'0')}`
        },

        // Manipulação dos professores no cálculo das notas
        remove: {
            ids: [],
        },
        renderTable: false,

        init() {
            // 1. Calcula as notas de cada avaliador
            this.evaluations.forEach(evaluation => {
                const scores = calculateScores(
                    this.rubric,
                    this.students,
                    evaluation.groupSelections,
                    evaluation.individualSelections
                );

                evaluation.totalScore = scores.totalScore;
                evaluation.groupRubricScore = scores.groupRubricScore;
                evaluation.averageIndividualScore = scores.averageIndividualScore;
                evaluation.individualStudentScores = scores.individualStudentScores;


            });

            // 2. Gera o panorama consolidado (para a tabela)
            this.generateConsolidatedResults();
        },

        generateConsolidatedResults() {
            this.renderTable = false;

            const groupRubricWeight = this.rubric.groupRubricWeight;
            const individualRubricWeight = this.rubric.individualRubricWeight;

            const results = {
                results: [],
                evaluations: [],
            };

            // Para cada aluno, calcula as notas de todos avaliadores + média
            this.students.forEach(student => {
                const studentResult = {
                    id: student.id,
                    name: student.name,
                    evaluators: [],
                    average: 0,
                };


                let sum = 0;
                let calcLength = 0;
                this.evaluations.forEach(evaluation => {
                    if(this.remove.ids.includes(evaluation.evaluatorId)) return;
                    const groupScore = evaluation.groupRubricScore;
                    const individualScore = evaluation.individualStudentScores[student.id] ?? 0;

                    const finalScore =
                        (groupScore * groupRubricWeight) / 100 +
                        (individualScore * individualRubricWeight) / 100;

                    studentResult.evaluators.push({
                        name: evaluation.evaluatorName,
                        score: finalScore,
                    });

                    sum += finalScore;
                    calcLength += 1;
                });

                studentResult.average = calcLength > 0 ? sum / calcLength : 0;
                results.results.push(studentResult);
            });

            // Também adiciona a linha “Nota do Grupo” geral
            const groupRow = {
                id: 'group',
                name: 'Nota do Grupo',
                evaluators: [],
                average: 0,
            };

            let groupSum = 0;
            let calcLength = 0;
            this.evaluations.forEach(evaluation => {
                if(this.remove.ids.includes(evaluation.evaluatorId)) return;
                groupRow.evaluators.push({
                    name: evaluation.evaluatorName,
                    score: evaluation.groupRubricScore,
                });
                groupSum += evaluation.groupRubricScore;
                calcLength += 1;
            });

            groupRow.average = calcLength > 0 ? groupSum / calcLength : 0;

            results.results.push(groupRow);

            this.evaluations.forEach(evaluation => {
                if(this.remove.ids.includes(evaluation.evaluatorId)) return;
                results.evaluations.push(evaluation);
            });

            this.$nextTick(() => {
                this.consolidatedResults = results;
                this.renderTable = true;
            });
        },

        /*
         * Esse getter garante que o container da tabela sempre vai ter uma altura equivalente ao total de linhas da tabela.
         * Isso é feito porque há um template envolvendo a tabela, que a apagada e a recria no DOM, isso provoca comportamento
         * visual indesejado.
         **/
        getTableMinHeight() {
            const rowHeight = 48; // altura média de cada linha (py-3 + text)
            const headerHeight = 48;
            const rows = this.consolidatedResults?.results?.length || 3;

            return headerHeight + (rows * rowHeight);
        },

        //Funções para comentários
        openCommentModal(axisType, criterionId, studentId = null) {
            // Encontra a avaliação que está ativa no separador (tab)
            const activeEvaluation = this.evaluations[this.activeTabIndex];

            // Se não encontrar uma avaliação ativa, não faz nada
            if (!activeEvaluation) {
                console.error("Não foi possível encontrar uma avaliação ativa.");
                return;
            }

            this.showCommentModal = true;
            this.currentCommentTarget = { axisType, criterionId, studentId };

            // Carrega o comentário existente (se houver) para dentro do textarea
            let existingComment = '';
            try {
                if (axisType === 'group') {
                    // *** CORREÇÃO AQUI ***
                    // Procura o comentário dentro da 'activeEvaluation'
                    existingComment = activeEvaluation.groupSelections?.[criterionId]?.comment ?? '';

                } else {
                    // *** CORREÇÃO AQUI ***
                    // Procura o comentário dentro da 'activeEvaluation'
                    existingComment = activeEvaluation.individualSelections[studentId]?.[criterionId]?.comment || '';
                }
            } catch (e) {
                console.error("Erro ao carregar comentário:", e);
            }

            this.currentCommentText = existingComment;

            //console.log('Comentário carregado:', this.currentCommentText);
            //console.log('Tipo:', axisType);

            // this.isCommentReadOnly = !!this.isReadOnly;
        },

        closeCommentModal() {
            this.showCommentModal = false;
            this.currentCommentText = '';
            this.currentCommentTarget = { axisType: null, criterionId: null, studentId: null };
        },

        goBack() {
            const fallback = '/calendar';

            if (!document.referrer) {
                window.location = fallback;
                return;
            }

            const current = new URL(window.location.href);
            const referrer = new URL(document.referrer);

            const samePage =
                current.pathname === referrer.pathname;

            window.location = samePage
                ? fallback
                : referrer.href;
        }
    };
}
