/** таблица тем */
const offerThemeTable = document.querySelector('#table-themes');
/** поле результата добавления */
const msgPrg = document.querySelector('#form-add-error');
/** форма создания оффера */
const addThemeForm = document.querySelector('#form-add-theme');
/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');
/** фрон-контроллер таблицы тем */
const offerThemeService = new OfferThemeTableClientController('/offer-theme', offerThemeTable, msgPrg, addThemeForm, csrfToken);