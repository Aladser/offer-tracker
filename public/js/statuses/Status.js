class Status
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
            this.switchStatus(draggableElement, 0);
        // включение
        } else {
            draggableElement.classList.remove(`${this.deactiveClass}__item`);
            draggableElement.classList.add(`${this.activeClass}__item`);
            draggableElement.classList.remove('bg-light');
            this.switchStatus(draggableElement, 1);
        }
    }

    /** отправка статуса оффера на сервер */
    switchStatus(id, status) {
        alert('метод switchStatus класса Status не реализoван');
        throw('метод switchStatus класса Status не реализoван');
    }

    /** установить обработчики событий */
    setListeners() {
        // включенные офферы
        this.activeList.querySelectorAll(`.${this.activeClass}__item`).forEach(item => item.ondragstart = e => this.onDragStart(e));
        // выключенные офферы
        this.deactiveList.querySelectorAll(`.${this.deactiveClass}__item`).forEach(item => item.ondragstart = e => this.onDragStart(e));
    }
}