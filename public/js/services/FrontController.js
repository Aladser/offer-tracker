/** Фронт-контроллер */
class FrontController {
    /** фронт-часть фронт-контроллера
     *
     * @param {*} URL URL бэк-контроллера
     * @param {*} table  таблица тем
     * @param {*} msgElement информационное поле ошибок
     * @param {*} form форма добавления темы
     * @param {*} csrfToken csrf-токен
     */
    constructor(URL, table, msgElement, form, csrfToken) {
      this.URL = URL;
      this.table = table;
      this.msgElement = msgElement;
      this.form = form;
      this.csrfToken = csrfToken;
  
      // клики строки таблицы
      this.table.querySelectorAll(`.${this.table.id}__tr`).forEach((row) => {
        row.onclick = (e) => this.clickRow(row, e.target.closest("tr"))
      })
  
      // таблица
      if (this.table !== null) {
        this.table.querySelectorAll(`.${this.table.id}__tr`).forEach(
          (row) =>
            (row.onclick = (e) => {
              if (e.target.tagName === "INPUT") {
                this.setStatus(e.target.closest("tr"), e.target)
              } else {
                this.clickRow(e.target.closest("tr"))
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
              form.reset()
              this.createRow(data);
              this.msgElement.textContent = ""
              this.table.querySelectorAll(`.${this.table.id}__tr`).forEach((row) => {
                row.onclick = (e) => this.clickRow(e.target.closest("tr"))
              })
            } else {
              this.msgElement.textContent = data.description;
            }
          } catch (e) {
            console.log(e)
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
            data = JSON.parse(data)
            if (data.result == 1) {
              row.remove()
              this.msgElement.textContent = ""
            } else {
              this.msgElement.textContent = data.description
            }
          } catch (e) {
            if (data.includes("<title>Page Expired</title>")) {
              window.open("/wrong-uri", "_self")
            } else {
              this.msgElement.textContent = data
            }
          }
        })
    }
  
    clickRow(row) {
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
  
    /** установить статус */
    setStatus(row, inputStatus) {
      let data = new URLSearchParams()
      data.set("id", row.getAttribute("data-id"))
      data.set("status", inputStatus.checked)
      let headers = { "X-CSRF-TOKEN": this.csrfToken.getAttribute("content") }
  
      let statusSwitch = row.querySelector("input[name='status']")
      fetch(`${this.URL}/status`, {
        method: "post",
        headers: headers,
        body: data,
      })
        .then((response) => response.text())
        .then((rslt) => {
          if (rslt == 1) {
            statusSwitch.title = inputStatus.checked ? "выключить" : "включить"
          } else {
            this.errorPrg.textContent = "серверная ошибка изменения статуса"
            console.log(rslt)
          }
        })
    }

    /** создать строку таблицы
     * 
     * @param {*} data данные из БД
     */
    createRow(data) {
      alert('нет реализации метода createRow');
    }

  }
  