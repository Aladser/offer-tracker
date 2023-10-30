/** Статус строки-подписки
 *
 * @param {*} activeClass id списка активных элементов
 * @param {*} deactiveClass id списка неактивных элементов
 * @param {*} url куда отправлять запрос
 */
class SubscriptionStatus extends Status {
    /** изменяет показ реферальной ссылки */
    process(data) {
        let subscription = document.getElementById(data.offer_id);
        if (data.result == 'SUBSCRIBE'){
            // подписка - добавление реферальной ссылки в элемент оффера
            subscription.innerHTML += `
                <a href="/?ref=${data.refcode}" title="${data.url}" class="font-semibold text-xl text-sky-600 subscriptions__ref">
                Реферальная ссылка
                </a>
            `;
        } else if (data.result == 'UNSUBSCRIBE') {
            // отписка - убирание реф.ссылки из элемента оффера
            subscription.querySelector(".subscriptions__ref").remove();
        } else {
            prgError.textContent = "Ошибка сервера";
            console.log(data);
        }
    }
}
