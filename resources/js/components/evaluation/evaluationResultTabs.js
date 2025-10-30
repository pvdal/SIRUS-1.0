export function evaluationResultTabs(initialData) {
    return {
        // Todos os dados da rubrica vêm do controller
        // O operador '...' (spread) "despeja" todas as chaves de initialData
        // (rubric, students, evaluations, groupName, etc.) para dentro do 'return'
        ...initialData,

        // Estado interno para controlar qual aba está ativa
        activeTabIndex: 0,
    }
}
