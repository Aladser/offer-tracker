class SubscriptionStatus extends Status
{
    /** отправка статуса оффера на сервер */
    switchStatus(elem, status) {
        let data = new URLSearchParams();
        data.set('id', elem.id);
        let headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        let url = this.url + (status == 1 ?  '/subscribe' : '/unsubscribe');
        fetch(url, {method: 'post', headers: headers, body: data})
            .then(response => response.text())
            .then(data => {
                try {
                    data = JSON.parse(data);
                    //console.log(data);
                    let result = data.result;
                    // ошибка
                    if (result == 0) {
                        prgError.textContent = 'Ошибка сервера. Подробности в консоли';
                        console.log(data);
                    } else if (result == 1) {
                        // отписка - убирание реф.ссылки из элемента оффера
                        elem.querySelector('.subscriptions__ref').remove();
                    } else {
                        // подписка - добавление реферальной ссылки в элемент оффера
                        elem.innerHTML += `<a href="dashboard?ref=${result}" title="?ref=${result}" class="fw-bolder fs-5 text-primary subscriptions__ref">Реферальная ссылка</a>`;
                    }
                } catch (err) {
                    console.log(data);
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