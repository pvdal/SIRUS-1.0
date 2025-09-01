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

        expandRows: false,
        contentHeight: 'auto', // faz altura ajustar conforme conteúdo
        //aspectRatio: 1, // opcional para ajustar a proporção
        eventSources:[
            {
                events: function (info, successCallback, failureCallback) {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    axios({
                        url: `/events/show`,
                        method: 'GET',
                        params: {
                            start: info.startStr,
                            end: info.endStr,
                        },
                        withCredentials: true
                    })
                    .then(response => {
                        successCallback(response.data);
                    })
                    .catch(error => {
                        console.error('Erro ao buscar eventos', error);
                        failureCallback(error);
                    });
                }
            }
        ],
        eventClick: function(info) {
            // info.event contém os dados do evento
            alert('Evento: ' + info.event.title);


        },
    });
    // Forçar view com base na largura da tela
    function enforceViewByWidth() {
        const weekBtn = document.querySelector('.fc-timeGridWeek-button');
        if (weekBtn) {
            if (window.innerWidth < 640) {
                weekBtn.style.display = 'none'; // esconde
                if (calendar.view.type === 'timeGridWeek') {
                    calendar.changeView('timeGridDay'); // força outra view
                }
            } else {
                weekBtn.style.display = ''; // mostra novamente
            }
        }
    }

    window.addEventListener('resize', () => {
        enforceViewByWidth();
        calendar.updateSize();
    });

    // Executa uma vez no load
    enforceViewByWidth();
    calendar.render();
});
