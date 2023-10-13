class OfferStatus extends Status {
    process(data, element) {
        if (!data.result) {
            this.errorPrg.textContent = "серверная ошибка изменения статуса";
            console.log(rslt);
        }
    }
}
