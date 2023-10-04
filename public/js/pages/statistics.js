/** форма переключателей временного периода */
const timeSwitcher = document.querySelector('#time-period-article__switcher');

/** таблица переключателей времени */
const times = new Map();
times.set('last-day', document.querySelector('#table-offers-last-day'));
times.set('last-month', document.querySelector('#table-offers-last-month'));
times.set('last-year', document.querySelector('#table-offers-last-year'));
times.set('all-time', document.querySelector('#table-offers'));

const setTimePeriod = setStatisticTime();
timeSwitcher.times.forEach(input => input.addEventListener('click', setTimePeriod));

/** установить временной промежуток временной промежуток */
function setStatisticTime() {
    let activeTimeRadio = document.querySelector('#table-offers');
    return function(e) {
        activeTimeRadio.classList.add('d-none');
        activeTimeRadio = times.get(e.target.value);
        activeTimeRadio.classList.remove('d-none');
    };
}