## Приложение SF-AdTech — трекер трафика, созданный для организации взаимодействия рекламодателей, которые хотят привлечь к себе на сайт посетителей, и веб-мастеров. 

**Проект построен на основе laravel 8. Вебсокет работает на linux**

### Запуск проекта

+ Cкачать соответствующие зависимости:
    + ``composer install``
    + ``npm install``

+ Включить модуль apache rewrite:

``sudo a2enmod rewrite``

+ Установить модули php:

``sudo apt install php libapache2-mod-php php-curl php-mysql php-mbstring``

+ Установить mysql:

``sudo apt install mysql-server mysql-client``

+ Создание БД 
    * Дамп <span style="color:blue">*/storage/dump.sql*</span>
    * или создать базу ``offer-tracker``, использовать миграции и сидирование ``php artisan migrate --seed``

Учетные данные для подключения к БД в файле <span style="color:blue">*.env*<span>

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=offer-tracker
    DB_USERNAME=admin
    DB_PASSWORD=@admin@
    ```

+ В файле <span style="color:blue">*.env*</span> в параметре ``TIMEZONE`` прописать номер часового пояса сервера, где запускается проект. В противном случае дата в БД и серверной части кода будет различаться, не будет корректно отображаться статистика офферов и подписок.

+ Запуск проекта 
    * через консоль: ``php artisan serve``.
    * через Apache: файл виртуального хоста: <span style="color:blue">*/storage/offer-tracker.local.conf*</span>. Предполагается, что сайт лежит в <span style="color:blue">*/var/www*</span>

+ для полной остановки сайта выполнить ``pkill -f offer-service`` для остановки вебсокета.

### Структура сайта

+ Главная **/**

    * Страница регистрации **/register**

    * Страница входа **/login**

    * Профиль **/dashboard**

    * Администратор

        - Пользователи **/users**

        - Темы офферов **/offer-theme**

    * Рекламодатель

        - Добавить оффер **/offer/create**

        - Статистика **/offer/statistics**

    * Веб-мастер

        - Статистика **/offer/statistics**

Посредники ``App\Http\Middleware\Roles\IsAdmin``, ``App\Http\Middleware\Roles\IsAdvertiser``, ``App\Http\Middleware\Roles\IsStatisticsPage`` ограничивают доступ к страницам ролей.

### Структура базы данных
![](/storage/db.png)

+ *users* - пользователи
+ *user_roles* - роли пользователей
+ *advertisers* - рекламодатели
+ *webmasters* - вебмастеры
+ *offers* - офферы
+ *offer_themes* - темы офферов
+ *offer_subscriptions* - подписки на офферы
+ *offer_clicks* - переходы по реферальным ссылкам
+ *system_options* - конфиг системы
+ f*ailed_offer_clicks* - неудачные переходы по ссылкам

### Вебсокет

Адрес вебсокета можно изменить в *.env*: ``WEBSOCKET_PORT``, ``WEBSOCKET_ADDR``.

Вебсокет применяется для обновления данных на страницах при добавлении данных в БД в режиме реального времени. Используются библиотеки: для cервера веб-сокета ``cboden/ratchet``, серверного клиента ``ratchet/pawl``, JS-клиента стандартный ``Websocket``. Для отправки сообщений в вебсокет сервером используется класс ``App\Services\WebsocketService``, метод ``send``. Серверный вебсокет использует класс ``App\ServerWebsocket``, для принятий сообщений клиентами от сервера используются клиентские вебсокет классы из папки <span style="color:blue">*/public/js/websockets*</span>. Клиентские вебсокеты расширяют базовый класс ``ClientWebsocket``. Название соответствует странице, на которой он применяется:

+ ``AdminClientWebsocket`` - dashboard администратора, 
+ ``AdvertiserClientWebsocket`` - dashboard рекламодателя,
+ ``WebmasterClientWebsocket`` - dashboard вебмастера,
+ ``RegisterClientWebsocket`` - страница пользователей администратора
+ ``MainClientWebsocket`` - главная страница,
+ ``StatisticsClientWebsocket`` - страница статистики

Посредник ``App\Http\Middleware\IsActiveWebsocket`` проверяет активность вебсокета и запускает, если выключен.

Серверный вебсокет запускается как отдельный процесс php-файл <span style="color:blue">*app/offer-service.php*</span> с помощью класса ``App\ScriptLinuxProcess``.

Статистика вебсокета: <span style="color:blue">*/storage/logs/websocket.log*</span>

### Верстка сайта

+ Для работы сайта требуется Javascript. При отключенном JS редирект на страницу */noscript*. 
+ Верстка страниц основана на blade-шаблонах. *app.blade* - шаблон страниц. Контент берется из соответствующей blade-страницы папки <span style="color:blue">/resources /views/pages</span>. blade-шаблоны страниц регистрации и входа в папке <span style="color:blue">*/resources/views/auth*</span>.
+ js-скрипты и css-файлы расположены в <span style="color:blue">*/public*</span> и подключаются через blade-шаблоны.


### Пользователи

База данных (БД) имеет четыре таблицы для пользователей: пользователи (``users``), роли (``user_roles``), рекламодатели (``advertisers``), веб-мастеры (``webmasters``). 

Есть три роли пользователя: *рекламодатель*, *веб-мастер*, *администратор*. Можно зарегистирироваться как рекламодатель или веб-мастер. Администратор может создавать и удалять пользователей, в том числе новых администраторов. В целях безопасности таблица пользователей администратора не отображает администратора *admin*.

Таблица рекламодателей и веб-мастеров создана для разделения отношений. БД имеет следующие отношения: таблица офферов ``offers`` -> таблица рекламодателей ``advertisers`` -> таблица пользователей ``users`` и таблица подписок на офферы ``offer_subscriptions`` -> таблица веб-мастеров ``webmasters`` -> таблица пользователей ``users``.

### Регистрация пользователя

Регистрация пользователя происходит через средства Laravel, контроллер регистрации ``App\Http\Controllers\Auth\RegisteredUserController``. Добавлена защита от подделки данных: проверяется, что выбрана роль рекламодатель или веб-мастер. Иначе редирект а страницу 404. В зависимости от роли добавляется запись в ``advertisers`` или ``webmasters``. В случае успешной регистрации вебсокет отправляет клиенту-администратору сообщение *NEW_REGISTRATION* о появлении нового пользователя. На странице администратора появляется новый пользователь. 

### Авторизация пользователя

Авторизация пользователя вынесена в контроллер пользователей - ``App\Http\Controllers\UserController``, метод ``authenticate``. При авторизации проверяется наличие пользователя в системе и активность учетной записи, которую может выключить администратор.

Администратор может отключить и удалить учетную запись. В случае удаления удаляются все связанные данные. Страницы сайта кроме главной страницы могут просматривать только авторизованные пользователи.

Имеются по умолчанию 7 пользователей:
+ **admin@mail.ru** - админ
+ **advertiser1@mail.ru**, advertiser2@mail.ru, advertiser3@mail.ru - рекламодатели
+ **webmaster1@mail.ru**, webmaster2@mail.ru, webmaster3@mail.ru - вебмастеры

Пароль у всех пользователей: **AAAAaaaa1111**

### Рекламодатели и веб-мастеры

Рекламодатель создаёт предложение (*offer*), определяя URL страницы, на которую он хочет приводить людей. В offer-е он указывает стоимость перехода по ссылке. Система определяет комиссию за свои услуги. Сервер после добавления оффера в БД расслылает клиентам в вебсокете сообщение *NEW_OFFER* веб-мастерам. Вебмастера видят ту долю стоимости оффера, которую получат они. Рекламодатель может включать/выключать и удалять свои офферы. При выключении оффер пропадает из страницы веб-мастеров, независимо того, подписаны ли они, в вебсокет посылается сообщение *VISIBLE_OFFER* или *UNVISIBLE_OFFER*. При удалении в вебсокет отправляется сообщение *DELETE_OFFER*. При создании оффера или переключении его статуса, на страницах вебмастеров данные обновляются без перезагрузки. При удалении оффера удаляются все записи о нем (подписки, переходы, из статистики системы и рекламодателя), исчезают с главной страницы и страниц веб-мастеров. Если сервер совершает описанные выше действия, то отправляет эту информацию клиентам (браузерам) через вебсокет. Браузер при получении информации из вебсокета динамически изменит содержание страницы.

Веб-мастера в системе видят активные офферы, подписываются на них, после чего система выдаёт им специальные ссылки, которые они должны разместить в любом виде у себя на ресурсе. Ссылка эта ведёт не на целевой URL, а на систему-редиректор, которая фиксирует переход, а затем перенаправляет клиента на страницу сайта рекламодателя. При подписке или отписке клиентам в вебсокете отправляется сообщение *SUBSCRIBE* или *UNSUBSCRIBE*.

Браузер управляет данными таблицы офферов через JS-контроллер ``OfferTableClientController`` и JS-класс ``OfferStatus``, данными подписок - JS-класс ``SubscriptionStatus``. Клиентский контроллер офферов обменивается данными с серверным контроллером офферов ``App\Http\Controllers\OfferController``, класс подписок - сервисом ``App\Services\SubscriptionService``.

### Администратор

+ На странице dashboard администратора отображена общая статистика системы.
+ Администратору доступна страница пользователей */users*, где он может добавлять, удалять и включать или отключать пользователей. Клиентский контроллер ``TableClientControllers/UserTableClientController`` управляет данными таблицы пользователей и отправляет изменения в серверный контроллер ``App\Http\Controllers\UserController``.
+ Администратору доступна страница тем офферов */offer-theme*, где он может их добавлять и удалять. Клиентский контроллер ``TableClientControllers/OfferThemeTableClientController`` управляет данными таблицы и отправляет изменения в серверный контроллер ``App\Http\Controllers\OfferThemeController``.
+ Администратор может изменить комиссию системы в % от стоимости оффера.  Комиссия изменяется и отправляется на сервер через js-класс ``CommissionCtl``. Сервер записывает комиссию в БД через контроллер ``SystemOptionController``, метод ``set_commission``.

### Dashboard

При входе на страницу */dashboard* рекламодатель и веб-мастер видят схожую по структуре таблицу. За отображение страницы отвечает одиночный контроллер ``App\Http\Controllers\DashboardController``. Рекламодатель видит список созданных им офферов, веб-мастер - список подписок и видимых офферов (выключенные офферы не отображаются). Таблица имеет две колонки, которые отображают активность. Для изменения статуса нужно мышью перенести оффер или подписку в соответствующую колонку. У каждого оффера рекламодателя отображается число подписчиков и кнопка удаления. За добавление, удаление, изменение активности офферов отвечает ресурсный контроллер ``App\Http\Controllers\OfferController``, изменение подписок - сервис ``App\Services\SubscriptionService``. Число подписчиков динамически меняется через вебсокет. Рекламодатель имеет кнопку добавить новый оффер. Вебмастер видит реферальные ссылки своих подписок, которые можно скопировать. При наведении на ссылку показывается ее название. Администратор видит статистику системы и комиссию системы, которую может изменить.

### Статистика

У рекламодателя и веб-мастера на странице */dashboard* есть ссылка на статистику */offer/statistics*, где у рекламодателя отображается временная статистика расходов офферов , у вебмастеров - доходов подписок. За отображение статистики отвечает класс ``App\Http\Controllers\StatisticController``, метод ``index``.
На странице в верстке находятся четыре таблицы статистики (последний день, последний месяц, последний год, все время), но отображается одна. При изменении переключателя времени показывается соответствующая таблица. Сервер формирует данные для страницы статистики через посредник ``App\Services\OfferStatistics``. Данный сервис формирует четыре таблицы для четырех промежутков времени. 

### Темы офферов

Администратору доступна страница тем офферов, где он может создавать и удалять темы.

### Система-редиректор SF-AdTech

В рамках работы все доступные реферальные ссылки отображаются на главной странице *offer-tracker.local*. Реферальная ссылка имеет вид *offer-tracker.local?A@B*, где A - id вебмастера, B - id оффера. Посредник ``App\Http\Middleware\IsOfferReference`` проверяет реферальную ссылку на корректность данных. Если такой реферальной ссылки не существует, то редирект на 404 страницу. В противном случае сервер делает запись в таблицу БД ``offer_clicks`` о переходе с указанием времени перехода и переходит на страницу рекламодателя. Факт перехода или ошибочной реферальной ссылки записывается в лог <span style="color:blue">*/storage/logs/offer_clicks.log*</span> и отправляет в вебсокет сообщение *CLICK* или *FAILED_OFFER*.

### Защита от уязвимостей

Общая защита: данные не передаются на сервер через GET-запросы.

+ Защита от CSRF-атак: при несовпадении csrf-токена редирект на страницу */wrongcsf*. Токен отправляется на сервер через скрытый токен формы или заголовок ``X-CSRF-TOKEN``.

+ Защита от SQL-инъекций:
    * используется библиотека Laravel ``Illuminate\Database\Eloquent``;
    * в обращениях к БД через Eloquent не используются SQL-запросы в чистом виде.

+ Защита от XSS-атак: Laravеl декодирует все вводимые данные.
