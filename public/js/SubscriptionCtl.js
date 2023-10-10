class SubscriptionCtl
{
    constructor(subscriptionsList, activeOffersList, subscribeURL, unsubscribeURL) {
        this.subscriptionsList = subscriptionsList;
        this.activeOffersList = activeOffersList;
        this.subscribeURL = subscribeURL;
        this.unsubscribeURL = unsubscribeURL;

        // офферы-подписки
        this.subscriptionsList.querySelectorAll('.subscriptions__item').forEach(item => item.ondragstart = e => this.onDragStart(e));
        this.subscriptionsList.ondragover = e => this.onDragOver(e);
        this.subscriptionsList.ondrop = e => this.onDrop(e);

        // доступные активные офферы
        this.activeOffersList.querySelectorAll('.offers__item').forEach(item => item.ondragstart = e => this.onDragStart(e));
        this.activeOffersList.ondragover = e => this.onDragOver(e);
        this.activeOffersList.ondrop = e => this.onDrop(e);
    }

    onDragStart(event) {
        event.dataTransfer.setData('text/plain', event.target.id);
    }

    onDragOver(event) {
        event.preventDefault();
    }

    onDrop(event) {
        let id = event.dataTransfer.getData('text');
        let draggableElement = document.getElementById(id);
        let dropzone = event.target.closest('.table-items');
        
        // игнорирование перемещения реф.ссылки
        if (draggableElement == null) {
            return;
        }
        // если перемещаемый элемент не покидает изначальный контейнер
        if (dropzone.id.includes('subscription')&&draggableElement.id.includes('subscription')) {
            return;
        }
        if (dropzone.id.includes('offer')&&draggableElement.id.includes('offer')) {
            return;
        }

        dropzone.append(draggableElement);
        // отписка
        if (draggableElement.id.includes('subscription')) {
            id = draggableElement.id.substring(13);
            draggableElement.id = `offer-${id}`;
            draggableElement.classList.remove('subscriptions__item');
            draggableElement.classList.add('offers__item');
            draggableElement.classList.add('bg-light');
            this.switchSubscription(this.unsubscribeURL, id, draggableElement);
        // подписка
        } else {
            id = draggableElement.id.substring(6);
            draggableElement.id = `subscription-${id}`;
            draggableElement.classList.remove('offers__item');
            draggableElement.classList.add('subscriptions__item');
            draggableElement.classList.remove('bg-light');
            this.switchSubscription(this.subscribeURL, id, draggableElement);
        }
    }

    /** отправка переключения подписки на сервер */
    switchSubscription(URL, offerId, offer) {
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
                data = JSON.parse(data);
                let result = data.result;
                // ошибка
                if (result == 0) {
                    prgError.textContent = 'Ошибка сервера. Подробности в консоли';
                    console.log(data);
                } else if (result == 1) {
                    // отписка - убирание реф.ссылки из элемента оффера
                    offer.querySelector('.subscriptions__ref').remove();
                } else {
                    // подписка - добавление реферальной ссылки в элемент оффера
                    offer.innerHTML += `<a href="dashboard?ref=${result}" title="?ref=${result}" class="fw-bolder fs-5 text-primary subscriptions__ref">Реферальная ссылка</a>`;
                }
            } catch (err) {
                if (data.includes('<title>Page Expired</title>')) {
                    window.open('/wrong-uri', '_self');
                } else {
                    prgError.textContent = err;
                    console.log(data);
                }
            }
        });
    }
}