class OfferStatus extends Status
{
    /** отправка статуса оффера на сервер */
    switchStatus(element, status) {
        let data = new URLSearchParams();
        data.set('id', element.id);
        data.set('status', status);
        let headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        fetch(this.url, {method: 'post', headers: headers, body: data})
            .then(response => response.text())
            .then(data => {
                try {
                    data = JSON.parse(data);
                    let result = data.result;
                    // ошибка
                    if (result == 0) {
                        this.errorPrg.textContent = "серверная ошибка изменения статуса";
                        console.log(rslt);
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