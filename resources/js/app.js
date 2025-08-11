import './bootstrap';
import './calendar.js';

/*
 * Helpers
 */
import {saveData} from './helpers/saveData';
window.saveData = saveData; // Necessário para Alpine acessar

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
//Groups
import {groupsData} from "./components/management/groupsData.js";
window.groupsData = groupsData;
