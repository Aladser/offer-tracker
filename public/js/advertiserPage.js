/** URL */
const offerURL = '/offer';
/** имя текущего пользователя*/
const hostUsername = document.querySelector('#hostUsername');
/** форма создания оффера */
const addOfferForm = document.querySelector('#form-add-new-product');
/** поле ошибки формы добавления */
const errorPrg = document.querySelector('#form-add-error');
/** CSRF */
const csrfToken = document.querySelectorAll('meta')[2];
/** таблица офферов */
const offerTable = document.querySelector('#table-offers tbody');

/** фронт-контроллер офферов */
const offerFrontCtl = new OfferFrontCtl(offerURL, hostUsername, addOfferForm, offerTable, errorPrg, csrfToken);

/** строки таблицы офферов */
const offerTableRows = offerTable.querySelectorAll('tr');
// выделение
offerTableRows.forEach(row => row.addEventListener('click', function(){
    if (this.classList.contains('table-offers__tr--active')) {
        this.classList.remove('table-offers__tr--active');
        row.querySelector('button').remove();
    } else {
        let activeRow = offerTable.querySelector('.table-offers__tr--active');
        if (activeRow) {
            activeRow.classList.remove('table-offers__tr--active');
            offerTable.querySelector('button').remove();
        }

        // кнопка удаления
        row.innerHTML += "<button id='table-offers__btn-remove' title='Удалить'>🗑</button>";
        row.lastChild.onclick = e => offerFrontCtl.remove(e.target);

        this.classList.add('table-offers__tr--active');
    }
}));