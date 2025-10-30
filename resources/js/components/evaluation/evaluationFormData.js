// export function evaluationFormData() { // <<<< VERSÃO ANTIGA
export function evaluationFormData(initialData) { // <<<< NOVA VERSÃO

    return {
        // --- DADOS DINÂMICOS (Vindos do Controller) ---
        // Todos os dados substituídos pelo parâmetro 'initialData'.
        evaluatorName: initialData.evaluatorName,
        groupName:     initialData.groupName,
        paperTitle:    initialData.paperTitle,
        paperProject:    initialData.paperProject,
        gradeLevels:   initialData.gradeLevels,
        students:      initialData.students,
        rubric:        initialData.rubric,
        userCommitteeId: initialData.userCommitteeId,

        // Vai ser usado para quando for apenas realizar leitura na avaliação
        isReadOnly:    initialData.isReadOnly,



        // --- ESTADO INTERNO (O que o usuário seleciona) ---
        groupSelections: initialData.groupSelections,
        individualSelections: initialData.individualSelections,
        saving: false,

        // --- MODAL DE CONFIRMAÇÃO---
        showWarningModal: false,
        warningType: '',
        warningContent: '',


        confirmSave() {
            // Trava de segurança
            if (this.saving || this.isReadOnly) return;

            let missingCriteria = [];

            this.rubric.axes.forEach(axis => {
                axis.criteria.forEach(criterion => {

                    // 2. Validar critérios 'in group'
                    if (axis.type === 'in group') {
                        if (!this.groupSelections[criterion.id]) {
                            // Se não houver seleção, adiciona ao array de erros
                            missingCriteria.push(`• ${criterion.name} (Grupo)`);
                        }
                    }
                    // 3. Validar critérios 'individual'
                    else if (axis.type === 'individual') {
                        // Precisa verificar para cada aluno
                        this.students.forEach(student => {
                            if (!this.individualSelections[student.id] || !this.individualSelections[student.id][criterion.id]) {
                                // Se não houver seleção para este aluno, adiciona ao erro
                                missingCriteria.push(`• ${criterion.name} (Aluno: ${student.name})`);
                            }
                        });
                    }
                });
            });
            if (missingCriteria.length > 0) {
                // ERRO: Existem critérios faltando.
                this.warningType = 'Erro';

                let errorHtml = 'Por favor, preencha todos os campos obrigatórios:<br><ul class="list-disc list-inside text-left">';
                errorHtml += missingCriteria.map(name => `<li>${name}</li>`).join('');
                errorHtml += '</ul>';

                this.warningContent = errorHtml;
                this.showWarningModal = true;

            } else {
                // modal de CONFIRMAÇÃO.
                this.warningType = 'Confirmação';
                this.warningContent = 'Tem certeza de que deseja enviar esta avaliação? Após o envio, ela não poderá mais ser editada.';
                this.showWarningModal = true;
            }
        },

        submitEvaluation() {
            // Fecha o modal e inicia o estado de "salvando"
            this.showWarningModal = false;
            this.saving = true;

            // Trava de segurança extra
            if (this.isReadOnly) {
                this.saving = false;
                return;
            }

            // 1. Prepara os dados (Payload)
            const payload = {
                user_committee_id: this.userCommitteeId,
                group_evaluations: this.groupSelections,
                individual_evaluations: this.individualSelections,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            // 2. Envia os dados para o Controller
            axios.post('/evaluation/store', payload)
                .then(response => {
                    alert('Avaliação salva com sucesso!');
                    // Recarrega a página para travar a avaliação (modo somente leitura)
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Erro ao salvar:', error.response);
                    alert('Ocorreu um erro ao salvar.');
                    // Se der erro, para de salvar para o usuário poder tentar de novo
                    this.saving = false;
                });
        },

        //Função auxiliar para limpar o modal ao fechar
        clearWarningFields() {
            this.warningType = '';
            this.warningContent = '';
        }

    }

}
