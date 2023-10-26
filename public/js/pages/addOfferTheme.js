/** таблица тем */
const offerThemeTable = document.querySelector("#table-themes");
/** поле результата добавления */
const msgPrg = document.querySelector("#form-add-error");
/** форма создания оффера */
const addThemeForm = document.querySelector("#form-add-theme");
/** фронт-контроллер таблицы тем */
const offerThemeTableController = new OfferThemeTableClientController(
    "/offer-theme",
    offerThemeTable,
    msgPrg,
    addThemeForm,
);
