import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import ptBrLocale from '@fullcalendar/core/locales/pt-br';

document.addEventListener('alpine:initialized', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;
    let filters = {
        search: '',
        course: '',
        project: '',
    }

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            right: 'today,prev,next'
        },

        navLinks: true, // Clicar nos eventos
        selectable: window.userPermissions.canManageEvents, // Selecionar uma área
        selectMirror: window.userPermissions.canManageEvents, // Indicar visualmente a área selecionada antes de confirmar
        longPressDelay: 1000,
        editable: true, // Permite redimensionar e arrastar eventos,

        locale: ptBrLocale, // Linguagem: portugês
        timeZone: 'local', // Fuso horário local
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },

        expandRows: false,
        contentHeight: 'auto', // faz altura ajustar conforme conteúdo
        aspectRatio: 1, // opcional para ajustar a proporção
        eventSources:[
            {
                events: function (info, successCallback, failureCallback) {
                    const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';
                    axios({
                        url: `${requestPrefix}/events`,
                        method: 'GET',
                        params: {
                            start: info.startStr,
                            end: info.endStr,
                            search: filters.search,
                            course: filters.course,
                            project: filters.project,
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
        loading: function(isLoading) {
            window.dispatchEvent(new CustomEvent('calendar-loading', {
                detail: { loading: isLoading }
            }));
        },

        select: function (info) {
            // Ajuste do endDate para não parecer que selecionou um a mais
            let endDate = info.end;

            if (info.allDay) {
                // Subtrai 1 dia quando for seleção de "dia inteiro"
                endDate = new Date(info.end);
                endDate.setDate(endDate.getDate() - 1);
            }

            window.dispatchEvent(new CustomEvent('open-create-modal', {
                bubbles: true,
                detail: {
                    dateStart: info.start,
                    timeStart: info.start,
                    dateEnd: endDate,
                    timeEnd: endDate,
                    allDay: info.allDay
                }
            }))
        },

        dateClick: function(info) {
            window.dispatchEvent(new CustomEvent('open-create-modal', {
                bubbles: true,
                detail: {
                    dateStart: info.date,
                    timeStart: info.date,
                    dateEnd: info.date,
                    timeEnd: info.date,
                    allDay: info.allDay
                }
            }))
        },

        eventClick: function(info) {
            // info.event contém os dados do evento
            // console.log(info.event.start, info.event.end);
            window.dispatchEvent(new CustomEvent('open-evaluation-modal', {
                bubbles: true,
                detail: {
                    id: info.event.id,
                    title: info.event.title,
                    group: info.event.extendedProps.group,
                    paper: info.event.extendedProps.paper,
                    committeeMembers: info.event.extendedProps.committeeMembers,
                    groupMembers: info.event.extendedProps.groupMembers,
                    dateStart: info.event.start,
                    timeStart: info.event.start,
                    dateEnd: info.event.end,
                    timeEnd: info.event.end,
                    allDay: info.event.allDay,
                    belongsTo: info.event.extendedProps.belongsTo,
                    evaluatedByUser: info.event.extendedProps.evaluatedByUser,
                }
            }))
        },

        eventDrop: function(info) {

            saveCalendarChange(info);
        },

        eventResize: function(info) {

            saveCalendarChange(info);
        }
    });

    function saveCalendarChange(info) {
        if (!window.userPermissions.canManageEvents) {info.revert(); return;}
        const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';

        const toLocalDate = (date) => {
            if (!date) return null;
            const local = new Date(date.getTime() - date.getTimezoneOffset() * 60000);
            return local.toISOString().split('T')[0];
        };

        const payload = {
            date_start: toLocalDate(info.event.start),
            time_start: info.event.start.toTimeString().split(' ')[0],
            date_end: info.event.end ? toLocalDate(info.event.end) : null,
            time_end: info.event.end ? info.event.end.toTimeString().split(' ')[0] : null,
            create: false,
        };

        axios.put(`${requestPrefix}/events/${info.event.id}/update`, payload, { withCredentials: true })
            .then(() => {
                console.log('Evento atualizado com sucesso!');
            })
            .catch(err => {
                console.error('Erro ao atualizar evento', err);

                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: {
                        style: 'danger',
                        message: (err.response?.data?.success === false && err.response?.data?.message) ? err.response?.data?.message : 'Erro ao atualizar evento!',
                    }
                }))
                // Aqui é que você reverte a alteração
                info.revert();
            });
    }

    window.addEventListener('resize', () => {
        enforceViewByWidth();
        calendar.updateSize();
    });

    window.addEventListener('reload-calendar', (e) => {
        if(e.detail.reload) {
            filters.search = e.detail.search ?? '';
            filters.course = e.detail.course ?? '';
            filters.project = e.detail.project ?? '';
            calendar.refetchEvents();
        }
    });

    // Listener para exportar o calendário do SIMBAJU
    window.addEventListener('export-simbaju-calendar', () => {
        // Pega a data atual que o calendário está mostrando
        const currentDate = calendar.getDate();
        const year = currentDate.getFullYear();

        // Pegar o semestre
        const month = currentDate.getMonth() + 1;
        const semester = (month <= 6) ? 1 : 2;

        // pegar o prefixo da rota
        const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';

        // Montamos o título
        const title = encodeURIComponent(`SIMBAJU ${year}/${semester}`);

        // Montamos a URL de exportação
        const exportUrl = `calendar/export/simbaju?year=${year}&semester=${semester}&title=${title}`;

        // Redireciona para iniciar o download
        window.location.href = exportUrl;
    });

    calendar.render();

    // Forçar view com base na largura da tela
    function enforceViewByWidth() {
        const weekBtn = document.querySelector('.fc-timeGridWeek-button');
        const monthBtn = document.querySelector('.fc-dayGridMonth-button');
        const dayBtn = document.querySelector('.fc-timeGridDay-button');
        if (weekBtn) {
            if (window.innerWidth < 381) {
                weekBtn.style.display = 'none'; // esconde
                if (calendar.view.type === 'timeGridWeek') {
                    calendar.changeView('timeGridDay'); // força outra view
                }
            } else {
                weekBtn.style.display = ''; // mostra novamente
            }

            if (window.innerWidth < 351) {
                monthBtn.style.display = 'none'; // esconde
                if (calendar.view.type === 'dayGridMonth') {
                    calendar.changeView('timeGridDay'); // força outra view
                }
                dayBtn.style.borderTopLeftRadius = "6px";
                dayBtn.style.borderBottomLeftRadius = "6px";
            } else {
                monthBtn.style.display = ''; // mostra novamente
                dayBtn.style.borderTopLeftRadius = '';
                dayBtn.style.borderBottomLeftRadius = '';
            }
        }
    }
    // Executa uma vez no load
    enforceViewByWidth();
});
