class OfferStatus extends Status
{
    process(data) {
        // ошибка
        if (!data.result) {
            this.errorPrg.textContent = "серверная ошибка изменения статуса";
            console.log(rslt);
        }
    }
}