// calculateScores.js
export function calculateScores(rubric, students, groupSelections, individualSelections) {
    const result = {
        totalScore: 0.0,
        groupRubricScore: 0.0,
        averageIndividualScore: 0.0,
        individualStudentScores: {},
    };

    const axes = rubric.axes;
    const groupRubricWeight = rubric.groupRubricWeight;
    const individualRubricWeight = rubric.individualRubricWeight;

    // --- 1. Grupo ---
    let totalGroupScore = 0.0;
    const groupAxes = axes.filter(a => a.type === 'in group');

    groupAxes.forEach(axis => {
        let axisSum = 0;
        const axisAmount = axis.amount;

        axis.criteria.forEach(criterion => {
            const grade = groupSelections?.[criterion.id];
            if (grade) axisSum += parseFloat(grade);
        });

        if (axisAmount > 0) {
            const axisAvg = axisSum / axisAmount;
            const axisWeightedScore = (axisAvg * axis.weight) / 100.0;
            totalGroupScore += axisWeightedScore;
        }
    });

    result.groupRubricScore = totalGroupScore;

    // --- 2. Individual ---
    let allIndividualScores = [];
    const individualAxes = axes.filter(a => a.type === 'individual');

    students.forEach(student => {
        let totalStudentScore = 0.0;
        const studentSelections = individualSelections?.[student.id] || {};

        individualAxes.forEach(axis => {
            let axisSum = 0;
            const axisAmount = axis.amount;

            axis.criteria.forEach(criterion => {
                const grade = studentSelections?.[criterion.id];
                if (grade) axisSum += parseFloat(grade);
            });

            if (axisAmount > 0) {
                const axisAvg = axisSum / axisAmount;
                const axisWeightedScore = (axisAvg * axis.weight) / 100.0;
                totalStudentScore += axisWeightedScore;
            }
        });

        result.individualStudentScores[student.id] = totalStudentScore;
        allIndividualScores.push(totalStudentScore);
    });

    // --- 3. Média individual ---
    if (allIndividualScores.length > 0) {
        const sumOfAll = allIndividualScores.reduce((a, b) => a + b, 0);
        result.averageIndividualScore = sumOfAll / allIndividualScores.length;
    }

    // --- 4. Nota final ---
    const finalGroupPart = (result.groupRubricScore * groupRubricWeight) / 100.0;
    const finalIndividualPart = (result.averageIndividualScore * individualRubricWeight) / 100.0;
    result.totalScore = finalGroupPart + finalIndividualPart;

    return result;
}
