class OfferStatus
{
    constructor(activeOfferList, deactiveOffersList, url) {
        this.activeOfferList = activeOfferList;
        this.deactiveOfferList = deactiveOffersList;
        this.url = url;

        this.activeOfferList.ondragover = e => this.onDragOver(e);
        this.activeOfferList.ondrop = e => this.onDrop(e);
        this.deactiveOfferList.ondragover = e => this.onDragOver(e);
        this.deactiveOfferList.ondrop = e => this.onDrop(e);
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
        if (dropzone.id === 'active-offers' && draggableElement.classList.contains('active-offers__item')) {
            return;
        }
        if (dropzone.id == 'deactive-offers' && draggableElement.classList.contains('deactive-offers__item')) {
            return;
        }

        dropzone.append(draggableElement);
        // выключение
        if (draggableElement.classList.contains('active-offers__item')) {
            draggableElement.classList.remove('active-offers__item');
            draggableElement.classList.add('deactive-offers__item');
            draggableElement.classList.add('bg-light');
            this.switchStatus(draggableElement.id, 0);
        // включение
        } else {
            draggableElement.classList.remove('deactive-offers__item');
            draggableElement.classList.add('active-offers__item');
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
        this.activeOfferList.querySelectorAll('.active-offers__item').forEach(item => item.ondragstart = e => this.onDragStart(e));
        // выключенные офферы
        this.deactiveOfferList.querySelectorAll('.deactive-offers__item').forEach(item => item.ondragstart = e => this.onDragStart(e));
    }
}