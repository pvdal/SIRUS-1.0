import './bootstrap';
import './calendar.js';

/**
 * Helpers
 */
// Salvar/Atualizar dados
import {saveData} from './helpers/saveData';
window.saveData = saveData; // Necessário para Alpine acessar
// Visualizar trabalho do aluno
import {paperViewer} from "./helpers/paperViewer.js";
window.paperViewer = paperViewer;
// Trata os timestamps
import {formatDateTime} from "./helpers/formatDateTime.js";
window.formatDateTime = formatDateTime;
// Limpa campos de formulário ou filtro
import {clearComponentData} from "./helpers/clearComponentData.js";
window.clearComponentData = clearComponentData;
/**
 * Scripts alpine
 */
// Users
import {professorsData} from "./components/management/professorsData.js";
window.professorsData = professorsData;
import {coordinatorsData} from "./components/management/coordinatorsData.js";
window.coordinatorsData = coordinatorsData;
import {studentsData} from "./components/management/studentsData.js";
window.studentsData = studentsData;
// Courses
import {coursesData} from "./components/management/coursesData.js";
window.coursesData = coursesData;
// Groups
import {groupsData} from "./components/management/groupsData.js";
window.groupsData = groupsData;
// Committees
import {committeesData} from "./components/evaluation/committeesData.js";
window.committeesData = committeesData;
// Calendar
import eventsData from "./components/evaluation/eventsData.js";
window.eventsData = eventsData;
// Evaluation
import {criteriaData} from "./components/evaluation/criteriaData.js";
window.criteriaData = criteriaData;
import {axesData} from "./components/evaluation/axesData.js";
window.axesData = axesData;
