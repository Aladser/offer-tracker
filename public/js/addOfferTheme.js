/** таблица тем */
const offerThemeTable = document.querySelector('#table-themes');

/** поле результата добавления */
const msgPrg = document.querySelector('#form-add-error');

/** форма создания оффера */
const addThemeForm = document.querySelector('#form-add-theme');

/** фрон-контроллер таблицы тем */
const offerThemeFrontCtl = new OfferThemeFrontCtl(
    '/offer-theme',
    offerThemeTable,
    msgPrg,
    addThemeForm,
    document.querySelector('meta[name="csrf-token"]')
);