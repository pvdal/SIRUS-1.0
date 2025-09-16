import './bootstrap';
import './calendar.js';

/*
 * Utils
 */
import {saveData} from './helpers/saveData'; // Salvar/Atualizar dados
window.saveData = saveData; // Necessário para Alpine acessar

import {paperViewer} from "./helpers/ShowPaper.js"; // Visualizar trabalho do aluno
window.paperViewer = paperViewer;

import {formatDateTime} from "./helpers/formatDateTime.js"; // Trata os timestamps
window.formatDateTime = formatDateTime;

import {clearComponentData} from "./helpers/clearComponentData.js";
window.clearComponentData = clearComponentData;
/*
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
import {calendarData} from "./components/evaluation/calendarData.js";
window.calendarData = calendarData;
// Evaluation
import {criteriaData} from "./components/management/criteriaData.js";
window.criteriaData = criteriaData;
