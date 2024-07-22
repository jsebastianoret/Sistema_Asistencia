let monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
let dayNames = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

let currentDate = new Date();
let currentDay = currentDate.getDate();
let monthNumber = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

let dates = document.getElementById('dates');
let month = document.getElementById('month');
let year = document.getElementById('year');
let daysN = document.getElementById('daysN');

month.textContent = monthNames[monthNumber];
year.textContent = currentYear;

/*for (let i = 0; i < dayNames.length; i++) {
    daysN.innerHTML += `<div class="calendar_dates calendar__day-names">${dayNames[i]}</div>`;
}*/

function cargarEventos() {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const eventos = JSON.parse(xhr.responseText);
                    resolve(eventos);
                } else {
                    reject(new Error(`Error en la solicitud. Estado: ${xhr.status}`));
                }
            }
        };
        xhr.open("GET", "../admin/includes/eventos-calendar-practicante.php", true);
        xhr.send();
    });
}

let practicante = document.getElementById('idPracticanteActividad');
let actividad = practicante.value;

cargarEventos()
    .then(eventos => {
        const eventosFiltrados = eventos.filter(evento => evento.idPracticante == actividad);

        const eventos2 = eventosFiltrados.map(evento => ({
            id: evento.id,
            titulo: evento.titulo,
            fecha_desde: evento.fecha_desde,
            fecha_hasta: evento.fecha_hasta,
            detalles: evento.detalles,
            color: evento.color,
            idPracticante: evento.idPracticante,
            fechas_repetidas: [
                { fecha_desde: evento.fecha_desde, fecha_hasta: evento.fecha_hasta },
            ]
        }));

        let prevMonthDOM = document.getElementById('prev-month');
        let nextMonthDOM = document.getElementById('next-month');

        const lastMonth = () => {
            if (monthNumber !== 0) {
                monthNumber--;
            } else {
                monthNumber = 11;
                currentYear--;
            }
            setNewDate();
        };

        const nextMonth = () => {
            if (monthNumber !== 11) {
                monthNumber++;
            } else {
                monthNumber = 0;
                currentYear++;
            }
            setNewDate();
        };

        const setNewDate = () => {
            currentDate.setFullYear(currentYear, monthNumber, currentDay);
            month.textContent = monthNames[monthNumber];
            year.textContent = currentYear;
            dates.textContent = '';
            writeMonth(monthNumber);
        };

        prevMonthDOM.addEventListener('click', () => lastMonth());
        nextMonthDOM.addEventListener('click', () => nextMonth());

        const writeMonth = (month) => {
            const totalDays = getTotalDays(month);
            const startDayOfWeek = startDay();
            const totalCells = 42;
            dates.innerHTML = '';
            for (let i = startDayOfWeek; i > 0; i--) {
                const day = getTotalDays(month - 1) - (i - 1);
                dates.innerHTML += `<div class="calendar_dates 1 calendar_last-days">${day}</div>`;
            }

            for (let i = 1; i <= totalDays; i++) {
                const className = i === currentDay ? 'calendar_today 2 calendar_border-top' : 'calendar_border-top';
                const dateKey = `${currentYear}-${(month + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
                const eventsForDate = eventos2.filter(evento => {
                    const eventStartDate = new Date(evento.fecha_desde);
                    const eventEndDate = new Date(evento.fecha_hasta);
                    const currentDate = new Date(dateKey);
                    return currentDate >= eventStartDate && currentDate <= eventEndDate;
                });
                const eventHtml = eventsForDate.map(evento => `
                    <div class="calendar__day-1" data-toggle="modal" data-target="#eventoModal">
                        <div class="tarea__calendar"  style="background-color: ${evento.color};"
                            data-toggle="modal" data-target="#eventoModalEdit"
                            onclick="mostrarDatos(${evento.id})">

                                <input type="hidden" id="actividad-${evento.id}" value="${evento.id}">
                                <input type="hidden" id="titulo-${evento.id}" value="${evento.titulo}">
                                <input type="hidden" id="desde-${evento.id}" value="${evento.fecha_desde}">
                                <input type="hidden" id="hasta-${evento.id}" value="${evento.fecha_hasta}">
                                <input type="hidden" id="detalles-${evento.id}" value="${evento.detalles}">
                                <input type="hidden" id="color-${evento.id}" value="${evento.color}">

                            ${evento.titulo}
                        </div>
                    </div>`).join('');

                const dayHtml = `<div class="calendar_dates calendar__day-2 ${className}" data-toggle="modal" data-target="#eventoModal">${i}${eventHtml}</div>`;
                dates.innerHTML += dayHtml;
            }
            const remainingCells = totalCells - startDayOfWeek - totalDays;
            const nextMonth = month + 1 > 11 ? 0 : month + 1;
            for (let i = 1; i <= remainingCells; i++) {
                dates.innerHTML += `<div class="calendar_dates 4 calendar_next-days">${i}</div>`;
            }
        };

        const getTotalDays = month => {
            if (month === -1) month = 11;
            if (month == 0 || month == 2 || month == 4 || month == 6 || month == 7 || month == 9 || month == 11) {
                return  31;
            } else if (month == 3 || month == 5 || month == 8 || month == 10) {
                return 30;
            } else {
                return isLeap() ? 29 : 28;
            }
        };

        const isLeap = () => {
            return ((currentYear % 100 !== 0) && (currentYear % 4 === 0) || (currentYear % 400 === 0));
        };

        const startDay = () => {
            let start = new Date(currentYear, monthNumber, 1);
            return ((start.getDay() - 1) === -1) ? 6 : start.getDay() - 1;
        };

        writeMonth(monthNumber);

        dates.addEventListener('click', (event) => {
            const selectedDate = parseInt(event.target.textContent);

            if (!isNaN(selectedDate)) {
                const fromDateInput = document.getElementById('fechaDesde');
                const fromDateInput2 = document.getElementById('fechaHasta');
                const selectedMonth = monthNumber + 1;
                const formattedSelectedDate = `${currentYear}-${selectedMonth.toString().padStart(2, '0')}-${selectedDate.toString().padStart(2, '0')}`;
                fromDateInput.value = formattedSelectedDate;
                fromDateInput2.value = formattedSelectedDate;

                const eventoModal = document.getElementById('eventoModal');
                if (eventoModal) {
                    eventoModal.style.display = 'none';
                }
            }
        });
        
    })
    .catch(error => {
        console.error("Ocurrió un error al cargar los eventos:", error);
    });

    function mostrarDatos(eventoId) {
        const inputId = document.getElementById(`actividad-${eventoId}`);
        const inputTitulo = document.getElementById(`titulo-${eventoId}`);
        const inputDesde = document.getElementById(`desde-${eventoId}`);
        const inputHasta = document.getElementById(`hasta-${eventoId}`);
        const inputDetalles = document.getElementById(`detalles-${eventoId}`);
        const inputColor = document.getElementById(`color-${eventoId}`);

        let idModal = document.getElementById("idModal");
        let TituloModal = document.getElementById("TituloModal");
        let desdeModal = document.getElementById("desdeModal");
        let hastaModal = document.getElementById("hastaModal");
        let detallesModal = document.getElementById("detallesModal");
        let colorModal = document.getElementById("colorModal");

        if (inputId) {
            const id = inputId.value;
            idModal.value =id;
        }
        if (inputTitulo) {
            const titulo = inputTitulo.value;
            TituloModal.value = titulo;
        }
        if (inputDesde) {
            const desde = inputDesde.value;
            desdeModal.value = desde;
        }
        if (inputHasta) {
            const hasta = inputHasta.value;
            hastaModal.value = hasta;
        }
        if (inputDetalles) {
            const detalles = inputDetalles.value;
            detallesModal.innerHTML = detalles;
        }
        if (inputColor) {
            const color = inputColor.value;
            colorModal.value = color;
        }
    }
    