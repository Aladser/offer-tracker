const subscribeURL = 'offer/subscribe';
const unsubscribeURL = 'offer/unsubscribe';

/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');
/** поле ошибки */
const prgError = document.querySelector('#prg-error');

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
        draggableElement.classList.add('bg-light');
        unsubscribe(id);
    } else {
        id = draggableElement.id.substring(6);
        draggableElement.id = `subscription-${id}`;
        draggableElement.classList.remove('offers__item');
        draggableElement.classList.add('subscriptions__item');
        draggableElement.classList.remove('bg-light');
        subscribe(id);
    }
    draggableElement.style.backgroundColor = 'white';
}

/** подписаться на оффер */
function subscribe(offerId) {
    let data = new URLSearchParams();
    data.set('offerId', offerId);
    let headers = {'X-CSRF-TOKEN': csrfToken.getAttribute('content')};

    fetch(subscribeURL, {method:'post', headers: headers, body:data}).then(response => response.text()).then(data => {
        try {
            result = JSON.parse(data).result;
            if (result !== 1) {
                prgError.textContent = data;
            }
        } catch(e) {
            prgError.textContent = data;
        }
    })
}

/** отписаться от оффера */
function unsubscribe(offerId) {
    let data = new URLSearchParams();
    data.set('offerId', offerId);
    let headers = {'X-CSRF-TOKEN': csrfToken.getAttribute('content')};

    fetch(unsubscribeURL, {method:'post', headers: headers, body:data}).then(response => response.text()).then(data => {
        try {
            result = JSON.parse(data).result;
            if (result !== 1) {
                prgError.textContent = data;
            }
        } catch(e) {
            prgError.textContent = data;
        }
    })
}