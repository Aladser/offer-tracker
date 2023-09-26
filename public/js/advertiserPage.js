/** таблица офферов */
const offerTable = document.querySelector('#table-offers tbody');
/** фронт-контроллер офферов */
const offerFrontCtl = new OfferFrontCtl('/offer', document.querySelector('meta[name="csrf-token"]'));

offerTable.querySelectorAll('.table-offers__tr').forEach(row => row.onclick = e => {
    if (e.target.tagName === 'INPUT') {
        offerFrontCtl.setOfferStatus(e.target.closest('tr'), e.target);
    } else {
        OfferFrontCtl.clickRow(offerTable, e.target.closest('tr'));
    }
});