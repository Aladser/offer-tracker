class SubscriptionStatus extends Status
{
    process(data, elem)
    {
        let result = data.result;
        // ошибка
        if (result == 0) {
            prgError.textContent = 'Ошибка сервера. Подробности в консоли';
            console.log(data);
        } else if (result == 1) {
            // отписка - убирание реф.ссылки из элемента оффера
            elem.querySelector('.subscriptions__ref').remove();
        } else {1
            // подписка - добавление реферальной ссылки в элемент оффера
            elem.innerHTML += `<a href="dashboard?ref=${result}" title="?ref=${result}" class="fw-bolder fs-5 text-primary subscriptions__ref">Реферальная ссылка</a>`;
        }
    }
}