let monthNames = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

let currentDate = new Date();
let currentDay = currentDate.getDate();
let monthNumber = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

let dates = document.getElementById('dates');
let month = document.getElementById('month');

month.textContent = monthNames[monthNumber];

const writeMonth = (month) => {
    const totalDays = getTotalDays(month);
    const startDayOfWeek = startDay();
    const totalCells = 42; // Total number of cells in a 7x6 grid

    // Clear the dates element
    dates.innerHTML = '';

    // Add the dates from the previous month
    for (let i = startDayOfWeek; i > 0; i--) {
        const day = getTotalDays(month - 1) - (i - 1);
        dates.innerHTML += `<div class="calendar_dates calendar_last-days">${day}</div>`;
    }

    // Add the dates of the current month
    for (let i = 1; i <= totalDays; i++) {
        const className = i === currentDay ? 'calendar_today calendar_border-top' : 'calendar_border-top';
        dates.innerHTML += `<div class="calendar_dates ${className}">${i}</div>`;
    }

    // Add additional dates from the next month if necessary
    const remainingCells = totalCells - startDayOfWeek - totalDays;
    const nextMonth = month + 1 > 11 ? 0 : month + 1;
    for (let i = 1; i <= remainingCells; i++) {
        dates.innerHTML += `<div class="calendar_dates calendar_next-days">${i}</div>`;
    }
};

const getTotalDays = month => {
    if(month === -1) month = 11;

    if (month == 0 || month == 2 || month == 4 || month == 6 || month == 7 || month == 9 || month == 11) {
        return  31;

    } else if (month == 3 || month == 5 || month == 8 || month == 10) {
        return 30;

    } else {

        return isLeap() ? 29:28;
    }
}

const isLeap = () => {
    return ((currentYear % 100 !==0) && (currentYear % 4 === 0) || (currentYear % 400 === 0));
}

const startDay = () => {
    let start = new Date(currentYear, monthNumber, 1);
    return ((start.getDay()-1) === -1) ? 6 : start.getDay()-1;
}

writeMonth(monthNumber);
