class OfferStatus
{
    constructor(activeClass, deactiveClass, url) {
        this.activeClass = activeClass;
        this.deactiveClass = deactiveClass;

        this.activeList = document.querySelector(`#${activeClass}`);
        this.deactiveList = document.querySelector(`#${deactiveClass}`);
        this.url = url;

        this.activeList.ondragover = e => this.onDragOver(e);
        this.activeList.ondrop = e => this.onDrop(e);
        this.deactiveList.ondragover = e => this.onDragOver(e);
        this.deactiveList.ondrop = e => this.onDrop(e);
        this.setListeners();
    }

    onDragStart(event) {
        event.dataTransfer.setData('text/plain', event.target.id);
    }
    
    onDragOver(event) {
        event.preventDefault();
    }

    onDrop(event) {
        let itemId = event.dataTransfer.getData('text');
        let draggableElement = document.getElementById(itemId);
        let dropzone = event.target.closest('.table-items');
        
        // если перемещаемый элемент не покидает изначальный контейнер
        if (dropzone.id === this.activeClass && draggableElement.classList.contains(`${this.activeClass}__item`)) {
            return;
        }
        if (dropzone.id == this.deactiveClass && draggableElement.classList.contains(`${this.deactiveClass}__item`)) {
            return;
        }

        dropzone.append(draggableElement);
        // выключение
        if (draggableElement.classList.contains(`${this.activeClass}__item`)) {
            draggableElement.classList.remove(`${this.activeClass}__item`);
            draggableElement.classList.add(`${this.deactiveClass}__item`);
            draggableElement.classList.add('bg-light');
            this.switchStatus(draggableElement.id, 0);
        // включение
        } else {
            draggableElement.classList.remove(`${this.deactiveClass}__item`);
            draggableElement.classList.add(`${this.activeClass}__item`);
            draggableElement.classList.remove('bg-light');
            this.switchStatus(draggableElement.id, 1);
        }
    }

    /** отправка статуса оффера на сервер */
    switchStatus(id, status) {
        let data = new URLSearchParams();
        data.set('id', id);
        data.set('status', status);
        let headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        fetch(this.url, {method: 'post', headers: headers, body: data})
            .then(response => response.text())
            .then(rslt => {
                if (rslt != 1) {
                    if (rslt.includes("<title>Page Expired</title>")) {
                        window.open("/wrong-uri", "_self");
                    } else {
                        this.errorPrg.textContent = "серверная ошибка изменения статуса";
                        console.log(rslt);
                    }
                }
            });
    }

    /** установить обработчики событий */
    setListeners() {
        // включенные офферы
        this.activeList.querySelectorAll(`.${this.activeClass}__item`).forEach(item => item.ondragstart = e => this.onDragStart(e));
        // выключенные офферы
        this.deactiveList.querySelectorAll(`.${this.deactiveClass}__item`).forEach(item => item.ondragstart = e => this.onDragStart(e));
    }
}