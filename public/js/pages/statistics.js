/** форма переключателей временного периода */
const timeSwitcher = document.querySelector('#time-period-article__switcher');
/** пользователь*/
const user = document.querySelector("#element-username").textContent;

/** таблиц переключателей времени */
const tables = new Map();
tables.set('last-day', document.querySelector('#table-offers-last-day'));
tables.set('last-month', document.querySelector('#table-offers-last-month'));
tables.set('last-year', document.querySelector('#table-offers-last-year'));
tables.set('all-time', document.querySelector('#table-offers'));

const setTimePeriod = setStatisticTime();
timeSwitcher.times.forEach(input => input.addEventListener('click', setTimePeriod));

/** установить временной промежуток временной промежуток */
function setStatisticTime() {
    let activeTable = document.querySelector('#table-offers');
    return function(e) {
        activeTable.classList.add('d-none');
        activeTable = tables.get(e.target.value);
        activeTable.classList.remove('d-none');
    };
}


/** вебсокет */
const websocket = new StatisticsFrontWebsocket('ws://localhost:8888', user, tables);