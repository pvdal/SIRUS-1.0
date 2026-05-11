import './bootstrap';
import './calendar.js';
//import 'mathjax/es5/tex-mml-chtml.js';
//import './accessibility.js';

/**
 * Accessibility
 */
//import {daltonismFilters} from "./components/accessibility/daltonism-filters.js";
//window.daltonismFilters = daltonismFilters;
/**
 * Appearance
 */
import {themeHandler} from "./appearance/themeHandler.js";
window.themeHandler = themeHandler;
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
import {eventsData} from "./components/evaluation/eventsData.js";
window.eventsData = eventsData;
// Evaluation
import {criteriaData} from "./components/evaluation/criteriaData.js";
window.criteriaData = criteriaData;
import {axesData} from "./components/evaluation/axesData.js";
window.axesData = axesData;
import {rubricsData} from "./components/evaluation/rubricsData.js";
window.rubricsData = rubricsData;
import {evaluationFormData} from "./components/evaluation/evaluationFormData.js";
window.evaluationFormData = evaluationFormData;
import {evaluationResultTabs} from "./components/evaluation/evaluationResultTabs.js";
window.evaluationResultTabs = evaluationResultTabs;
import {calculateScores} from './helpers/calculeteScores.js';
window.calculateScores = calculateScores;
// Papers
import {papersData} from "./components/management/papersData.js";
window.papersData = papersData;
