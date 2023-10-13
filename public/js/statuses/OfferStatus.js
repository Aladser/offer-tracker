class OfferStatus extends Status
{
    process(element, data) {
        if (!data.result) {
            this.errorPrg.textContent = "серверная ошибка изменения статуса";
            console.log(rslt);
        }
    }
}