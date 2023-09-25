/** Фронт-контроллер таблицы */
class OfferThemeFrontCtl {
    constructor(URL, csrfToken) {        
        this.URL = URL;
        this.csrfToken = csrfToken;
    }
    
    add(form, offerThemeTable, msgHTMLElement, event) {
        event.preventDefault();
        let formData = new FormData(form);

        fetch(this.URL, {method:'post', body:formData}).then(response => response.json()).then(data => {
            if (data.result == 1) {
                form.reset();
                offerThemeTable.innerHTML += `<tr data-id="${data.row.id}" class='table-themes__tr position-relative'><td>${data.row.name}</td></tr>`;
                msgHTMLElement.textContent = "";
                offerThemeTable.querySelectorAll('.table-themes__tr').forEach(row => row.onclick = e => OfferThemeFrontCtl.clickRow(e.target.closest('tr')));
            } else {
                msgHTMLElement.textContent = data.result;
            }
        })
    }

    remove(button) {
        let row = button.closest('tr'); 
        let id = row.getAttribute('data-id');
        let headers = {'X-CSRF-TOKEN': this.csrfToken.getAttribute('content')};

        fetch(`${this.URL}/${id}`, {method:'delete', headers: headers}).then(response => response.text()).then(data => {
            row.remove();
        })
    }

    static clickRow(row) {
        if (row.classList.contains('table-themes__tr--active')) {
            row.classList.remove('table-themes__tr--active');
            row.querySelector('button').remove();
        } else {
            let activeRow = offerThemeTable.querySelector('.table-themes__tr--active');
            if (activeRow) {
                activeRow.classList.remove('table-themes__tr--active');
                offerThemeTable.querySelector('button').remove();
            }

            row.innerHTML += "<button id='table-themes__btn-remove' title='Удалить'>🗑</button>";
            row.lastChild.onclick = e => offerThemeFrontCtl.remove(e.target);
            row.classList.add('table-themes__tr--active');
        }
    }
}