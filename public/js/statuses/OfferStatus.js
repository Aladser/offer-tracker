class OfferStatus extends Status
{
    /** отправка статуса оффера на сервер */
    switchStatus(id, status) {
        let data = new URLSearchParams();
        data.set('id', id);
        data.set('status', status);
        let headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        fetch(this.url, {method: 'post', headers: headers, body: data})
            .then(response => response.text())
            .then(rslt => {
                if (rslt != 1) {
                    if (rslt.includes("<title>Page Expired</title>")) {
                        window.open("/wrong-uri", "_self");
                    } else {
                        this.errorPrg.textContent = "серверная ошибка изменения статуса";
                        console.log(rslt);
                    }
                }
            });
    }
}