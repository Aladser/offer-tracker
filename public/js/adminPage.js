/** фрон-контроллер таблицы тем */
const offerThemeFrontCtl = new OfferThemeFrontCtl(
    '/offer-theme', 
    document.querySelector('meta[name="csrf-token"]')
);
/** поле результата добавления */
const msgPrg = document.querySelector('#form-add-error');
/** таблица тем */
const offerThemeTable = document.querySelector('#table-themes');
offerThemeTable.querySelectorAll('.table-themes__tr').forEach(row => {
        row.onclick = e => OfferThemeFrontCtl.clickRow(e.target.closest('tr'));
    }
);

/** форма создания оффера */
const addThemeForm = document.querySelector('#form-add-theme');
/** добавление темы */
addThemeForm.onsubmit = event => {
    offerThemeFrontCtl.add(
        addThemeForm, 
        offerThemeTable.querySelector('tbody'), 
        msgPrg, 
        event
    );
};