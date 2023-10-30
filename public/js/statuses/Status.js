class Status {
    /** Статус строки
     *
     * @param {*} activeClass id списка активных элементов
     * @param {*} deactiveClass id списка неактивных элементов
     * @param {*} url куда отправлять запрос
     * @param {*} prgError поле ошибок
     */
    constructor(activeClass, deactiveClass, url, prgError) {
        // класс списка активных элементов
        this.activeClass = activeClass;
        // класс списка выключенных элементов
        this.deactiveClass = deactiveClass;
        // элемент-список активных элементов
        this.activeList = document.querySelector(`#${activeClass}`);
        // элемент-список неактивных элементов
        this.deactiveList = document.querySelector(`#${deactiveClass}`);
        // url запроса
        this.url = url;
        /** поле ошибок */
        this.prgError = prgError;

        this.activeList.ondragover = (e) => this.onDragOver(e);
        this.activeList.ondrop = (e) => this.onDrop(e);
        this.deactiveList.ondragover = (e) => this.onDragOver(e);
        this.deactiveList.ondrop = (e) => this.onDrop(e);
        // установить обработчики событий. После перемещения элемента события сбрасываются
        this.setListeners();
    }

    // начало переноса
    onDragStart(event) {
        event.dataTransfer.setData("text/plain", event.target.id);
    }

    onDragOver(event) {
        event.preventDefault();
    }

    onDrop(event) {
        let itemId = event.dataTransfer.getData("text");
        let draggableElement = document.getElementById(itemId);
        let dropzone = event.target.closest(".table-items");
        // если переносится нецелевой элемент
        if (draggableElement === null) {
            return;
        }

        // если перемещаемый элемент не покидает изначальный контейнер
        if (
            dropzone.id === this.activeClass &&
            draggableElement.classList.contains(`${this.activeClass}__item`)
        ) {
            return;
        } else if (
            dropzone.id == this.deactiveClass &&
            draggableElement.classList.contains(`${this.deactiveClass}__item`)
        ) {
            return;
        }

        // перемещаемый элемент добавляется в новый контейнер
        dropzone.append(draggableElement);
        // выключение элемента (правая колонка)
        if (draggableElement.classList.contains(`${this.activeClass}__item`)) {
            draggableElement.classList.remove(`${this.activeClass}__item`);
            draggableElement.classList.add(`${this.deactiveClass}__item`);
            draggableElement.classList.add("bg-slate-100");
            this.switchStatus(draggableElement, 0);
        // включение элемента (левая колонка)
        } else {
            draggableElement.classList.remove(`${this.deactiveClass}__item`);
            draggableElement.classList.add(`${this.activeClass}__item`);
            draggableElement.classList.remove("bg-slate-100");
            this.switchStatus(draggableElement, 1);
        }
    }

    /** отправка статуса оффера на сервер */
    switchStatus(element, status) {
        let data = new URLSearchParams();
        data.set("id", element.id);
        data.set("status", status);
        let headers = {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        };
        // запрос на сервер
        ServerRequest.execute(
            this.url,
            this.process,
            "post",
            this.prgError,
            data,
            headers
        );
    }

    process(data) {
        let info = "функция process класса Status не реализована";
        alert(info);
        throw info;
    }

    /** установить обработчики событий */
    setListeners() {
        // включенные офферы
        this.activeList
            .querySelectorAll(`.${this.activeClass}__item`)
            .forEach((item) => (item.ondragstart = (e) => this.onDragStart(e)));
        // выключенные офферы
        this.deactiveList
            .querySelectorAll(`.${this.deactiveClass}__item`)
            .forEach((item) => (item.ondragstart = (e) => this.onDragStart(e)));
    }
}
