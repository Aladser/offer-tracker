const subscribeURL = 'offer/subscribe';
const unsubscribeURL = 'offer/unsubscribe';

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
		switchSubscription(unsubscribeURL, id, draggableElement);
	} else {
		id = draggableElement.id.substring(6);
		draggableElement.id = `subscription-${id}`;
		draggableElement.classList.remove('offers__item');
		draggableElement.classList.add('subscriptions__item');
		draggableElement.classList.remove('bg-light');
		switchSubscription(subscribeURL, id, draggableElement);
	}
	draggableElement.style.backgroundColor = 'white';
}

function switchSubscription(URL, offerId, offer) {
	let data = new URLSearchParams();
	data.set('offerId', offerId);
	let headers = {
		'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
	};

	fetch(URL, {
		method: 'post',
		headers: headers,
		body: data
	}).then(response => response.text()).then(data => {
		try {
			let result = JSON.parse(data).result;
			if (result == 0) {
				prgError.textContent = 'Ошибка сервера. Подробности в консоли';
				console.log(data);
			} else if (result == 1) {
				offer.querySelector('.subscriptions__ref').remove();
			} else {
				offer.innerHTML += `<a href="dashboard?ref=${result}" title="?ref=${result}" class="fw-bolder fs-5 text-primary subscriptions__ref">Реферальная ссылка</a>`;
			}
		} catch (e) {
			if (data.includes('<title>Page Expired</title>')) {
				window.open('/wrong-uri', '_self');
			} else {
				prgError.textContent = 'Ошибка сервера. Подробности в консоли';
				console.log(data);
			}
		}
	});
}