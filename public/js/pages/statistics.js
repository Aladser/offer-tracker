/** форма переключателей временного периода */
const timeSwitcher = document.querySelector("#time-period-article__switcher");
/** таблиц переключателей времени */
const tables = new Map();
tables.set("last-day", document.querySelector("#table-offers-last-day"));
tables.set("last-month", document.querySelector("#table-offers-last-month"));
tables.set("last-year", document.querySelector("#table-offers-last-year"));
tables.set("all-time", document.querySelector("#table-offers"));

/** вебсокет */
const websocket = new StatisticsClientWebsocket(tables);

// единая функция переключения таблицы для всех радиокнопок времени
const setTimePeriod = setStatisticTime();
timeSwitcher.times.forEach((input) =>
    input.addEventListener("click", setTimePeriod)
);
/** переключение таблицы статистики при переключении времени */
function setStatisticTime() {
    let activeTable = document.querySelector("#table-offers");
    return function (e) {
        activeTable.classList.add("hidden");
        activeTable = tables.get(e.target.value);
        activeTable.classList.remove("hidden");
    };
}
