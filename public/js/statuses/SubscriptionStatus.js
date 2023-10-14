/** Статус строки-подписки
 *
 * @param {*} activeClass id списка активных элементов
 * @param {*} deactiveClass id списка неактивных элементов
 * @param {*} url куда отправлять запрос
 */
class SubscriptionStatus extends Status {
    /** изменяет показ реферальной ссылки */
    process(data, subscription) {
        let result = data.result;
        // ошибка
        if (result == 0) {
            prgError.textContent = "Ошибка сервера. Подробности в консоли";
            console.log(data);
        } else if (result == 1) {
            // отписка - убирание реф.ссылки из элемента оффера
            subscription.querySelector(".subscriptions__ref").remove();
        } else {
            // подписка - добавление реферальной ссылки в элемент оффера
            subscription.innerHTML += `<a href="dashboard?ref=${result}" title="?ref=${result}" class="fw-bolder fs-5 text-primary subscriptions__ref">Реферальная ссылка</a>`;
        }
    }
}
