/** Статус строки-оффера
 *
 * @param {*} activeClass id списка активных элементов
 * @param {*} deactiveClass id списка неактивных элементов
 * @param {*} url куда отправлять запрос
 */
class OfferStatus extends Status {
    process(data, element) {
        if (!data.result) {
            this.errorPrg.textContent = "серверная ошибка изменения статуса";
            console.log(rslt);
        }
    }
}
