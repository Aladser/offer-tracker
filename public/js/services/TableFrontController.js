/** Фронт-контроллер */
class TableFrontController {
    /** фронт-часть фронт-контроллера
     *
     * @param {*} URL URL бэк-контроллера
     * @param {*} table  таблица тем
     * @param {*} msgElement инфоэлемент
     * @param {*} form форма добавления элемента
     * @param {*} csrfToken csrf-токен
     */
    constructor(URL, table, msgElement, form, csrfToken) {
      this.URL = URL;
      this.table = table;
      this.msgElement = msgElement;
      this.form = form;
      this.csrfToken = csrfToken;
  
      // таблица
      if (this.table !== null) {
        this.table.querySelectorAll(`.${this.table.id}__tr`).forEach(
          (row) =>
            (row.onclick = (e) => {
              if (e.target.tagName === "INPUT") {
                this.setStatus(e.target.closest("tr"), e.target)
              } else {
                this.click(e.target.closest("tr"))
              }
            })
        )
      }
  
      // форма добавления нового элемента
      if (this.form !== null) {
        this.form.onsubmit = (event) => this.add(form, event)
      }
    }
  
    add(form, event) {
      event.preventDefault()
      let formData = new FormData(form)
      let headers = { "X-CSRF-TOKEN": this.csrfToken.getAttribute("content") }
  
      fetch(this.URL, { method: "post", headers: headers, body: formData })
        .then((response) => response.text())
        .then((data) => {
          try {
            data = JSON.parse(data)
            if (data.result == 1) {
              this.processData(form, data);
            } else {
              this.msgElement.textContent = data.description;
            }
          } catch (e) {
            if (data.includes("<title>Page Expired</title>")) {
              window.open("/wrong-uri", "_self")
            } else {
              this.msgElement.textContent = data;
            }
          }
        })
    }

    remove(button) {
      let row = button.closest("tr")
      let id = row.getAttribute("data-id")
      let headers = { "X-CSRF-TOKEN": this.csrfToken.getAttribute("content") }
  
      fetch(`${this.URL}/${id}`, { method: "delete", headers: headers })
        .then((response) => response.text())
        .then((data) => {
          try {
            data = JSON.parse(data);
            if (data.result == 1) {
              row.remove();
              this.msgElement.textContent = "";
            } else {
              this.msgElement.textContent = data;
            }
          } catch (err) {
            console.log(err);
            if (data.includes("<title>Page Expired</title>")) {
              window.open("/wrong-uri", "_self")
            } else {
              this.msgElement.textContent = err;
            }
          }
        })
    }
  
    click(row) {
      if (row.classList.contains(`${this.table.id}__tr--active`)) {
        row.classList.remove(`${this.table.id}__tr--active`)
        row.querySelector("button").remove()
      } else {
        let activeRow = this.table.querySelector(`.${this.table.id}__tr--active`)
        if (activeRow) {
          activeRow.classList.remove(`${this.table.id}__tr--active`)
          this.table.querySelector("button").remove()
        }
  
        row.innerHTML +=
          `<button id='${this.table.id}__btn-remove' title='Удалить'>🗑</button>`
        row.lastChild.onclick = (e) => this.remove(e.target)
        row.classList.add(`${this.table.id}__tr--active`)
      }
    }
  
    processData(data) {
      alert('нет реализации метода processData');
    }

  }
  