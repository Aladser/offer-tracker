/** таблица офферов */
const offerTable = document.querySelector('#table-offers tbody');
/** фронт-контроллер офферов */
const offerFrontCtl = new OfferFrontCtl('/offer', document.querySelector('meta[name="csrf-token"]'));

offerTable.querySelectorAll('.table-offers__tr').forEach(row => row.onclick = e => {
    if (e.target.tagName === 'INPUT') {
        offerFrontCtl.setOfferStatus(e.target.closest('tr'), e.target);
    } else {
        clickRow(e.target.closest('tr'));
    }
});


/** клик строки таблицы */
function clickRow(row) {
    if (row.classList.contains('table-offers__tr--active')) {
        row.classList.remove('table-offers__tr--active');
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

        row.classList.add('table-offers__tr--active');
    }
}
