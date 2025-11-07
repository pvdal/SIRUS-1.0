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
            const groupRubricWeight = this.rubric.groupRubricWeight;
            const individualRubricWeight = this.rubric.individualRubricWeight;

            const results = [];

            // Para cada aluno, calcula as notas de todos avaliadores + média
            this.students.forEach(student => {
                const studentResult = {
                    id: student.id,
                    name: student.name,
                    evaluators: [],
                    average: 0,
                };

                let sum = 0;
                this.evaluations.forEach(evaluation => {
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
                });

                studentResult.average = this.evaluations.length > 0 ? sum / this.evaluations.length : 0;
                results.push(studentResult);
            });

            // Também adiciona a linha “Nota do Grupo” geral
            const groupRow = {
                id: 'group',
                name: 'Nota do Grupo',
                evaluators: [],
                average: 0,
            };
            let groupSum = 0;

            this.evaluations.forEach(evaluation => {
                groupRow.evaluators.push({
                    name: evaluation.evaluatorName,
                    score: evaluation.groupRubricScore,
                });
                groupSum += evaluation.groupRubricScore;
            });
            groupRow.average = this.evaluations.length > 0 ? groupSum / this.evaluations.length : 0;

            results.push(groupRow);

            this.consolidatedResults = results;
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

            console.log('Comentário carregado:', this.currentCommentText);
            console.log('Tipo:', axisType);

            // this.isCommentReadOnly = !!this.isReadOnly;
        },

        closeCommentModal() {
            this.showCommentModal = false;
            this.currentCommentText = '';
            this.currentCommentTarget = { axisType: null, criterionId: null, studentId: null };
        }
    };
}
