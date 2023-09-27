// офферы-подписки
const subscriptionsList = document.querySelector('#list-subscriptions');
subscriptionsList.querySelectorAll('.subscriptions__item').forEach(item => item.ondragstart = onDragStart);
subscriptionsList.ondragover = onDragOver;
subscriptionsList.ondrop = onDrop;

// доступные активные офферы
const activeOffersList = document.querySelector('#list-active-offers');
activeOffersList.querySelectorAll('.offers__item').forEach(item => item.ondragstart = onDragStart);
activeOffersList.ondragover = onDragOver;
activeOffersList.ondrop = onDrop;

// функции событий
function onDragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.id);
    event.currentTarget.style.backgroundColor = '#ddd';
}

function onDragOver(event) {
    event.preventDefault();
}

function onDrop(event) {
    let id = event.dataTransfer.getData('text');
    let draggableElement = document.getElementById(id);
    let dropzone = event.target.closest('.table-items');
    dropzone.append(draggableElement);
    
    if (draggableElement.id.includes('subscription')) {
        id = draggableElement.id.substring(13);
        draggableElement.id = `offer-${id}`;
        draggableElement.classList.remove('subscriptions__item');
        draggableElement.classList.add('offers__item');
    } else {
        id = draggableElement.id.substring(6);
        draggableElement.id = `subscription-${id}`;
        draggableElement.classList.remove('offers__item');
        draggableElement.classList.add('subscriptions__item');
    }
    draggableElement.style.backgroundColor = 'white';
}

/** подписаться на оффер */
function subscribe(offer) {

}

/** отписаться от оффера */
function unsubscribe(offer) {

}