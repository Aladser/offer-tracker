class Status {
    /** Статус строки
     *
     * @param {*} activeClass id списка активных элементов
     * @param {*} deactiveClass id списка неактивных элементов
     * @param {*} url куда отправлять запрос
     */
    constructor(activeClass, deactiveClass, url, prgError) {
        this.activeClass = activeClass; // колонка активных элементов
        this.deactiveClass = deactiveClass; // колонка выключенных элементов

        this.activeList = document.querySelector(`#${activeClass}`);
        this.deactiveList = document.querySelector(`#${deactiveClass}`);
        this.url = url;
        /** поле ошибок */
        this.prgError = prgError;

        this.activeList.ondragover = (e) => this.onDragOver(e);
        this.activeList.ondrop = (e) => this.onDrop(e);
        this.deactiveList.ondragover = (e) => this.onDragOver(e);
        this.deactiveList.ondrop = (e) => this.onDrop(e);
        this.setListeners();
    }

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

        // если перемещаемый элемент не покидает изначальный контейнер
        if (
            dropzone.id === this.activeClass &&
            draggableElement.classList.contains(`${this.activeClass}__item`)
        ) {
            return;
        }
        if (
            dropzone.id == this.deactiveClass &&
            draggableElement.classList.contains(`${this.deactiveClass}__item`)
        ) {
            return;
        }

        dropzone.append(draggableElement);
        // выключение элемента
        if (draggableElement.classList.contains(`${this.activeClass}__item`)) {
            draggableElement.classList.remove(`${this.activeClass}__item`);
            draggableElement.classList.add(`${this.deactiveClass}__item`);
            draggableElement.classList.add("bg-light");
            this.switchStatus(draggableElement, 0);
        // включение элемента
        } else {
            draggableElement.classList.remove(`${this.deactiveClass}__item`);
            draggableElement.classList.add(`${this.activeClass}__item`);
            draggableElement.classList.remove("bg-light");
            this.switchStatus(draggableElement, 1);
        }
    }

    /** отправка статуса оффера на сервер */
    async switchStatus(element, status) {
        let data = new URLSearchParams();
        data.set("id", element.id);
        data.set("status", status);
        let headers = {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        };

        let response = await fetch(this.url, {
            method: "post",
            headers: headers,
            body: data,
        });
        switch (response.status) {
            case 200:
                data = await response.json();
                this.process(data, element);
                break;
            case 419:
                window.open("/wrong-uri", "_self");
                break;
            default:
                this.msgElement.textContent =
                    "Серверная ошибка. Подробности в консоли браузера";
                console.log(response);
        }
    }

    process(data, element) {
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
