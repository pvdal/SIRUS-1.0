import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import ptBrLocale from '@fullcalendar/core/locales/pt-br';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            right: 'today,prev,next'
        },
        navLinks: true, // Clicar nos eventos
        selectable: true, // Selecionar uma área
        selectMirror: true, // Indicar visualmente a área selecionada antes de confirmar
        editable: true, //Permite redimensioanr e arrastar eventos,
        locale: ptBrLocale, // Linguagem: portugês
        timeZone: 'local', // Fuso horário local
        contentHeight: 'auto', // faz altura ajustar conforme conteúdo
        aspectRatio: 1, // opcional para ajustar a proporção
        events: '/events'

    });
    window.addEventListener('resize', () => {
        calendar.updateSize();
    });
    calendar.render();
});
