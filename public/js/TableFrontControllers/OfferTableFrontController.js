class OfferTableFrontController extends TableFrontController{
    constructor(URL, offerTable, msgPrg, addOfferForm, csrfToken, username) {
      super(URL, offerTable, msgPrg, addOfferForm, csrfToken);
      this.username = username;

      if (this.form !== null) {
        this.form.onsubmit = (event) => this.add(event);
      }

      /** вебсокет */
      this.websocket = new AdvertiserFrontWebsocket('ws://localhost:8888', this.username, this.table);
    }
  
    /** добавить оффер в БД
     * @param {*} form форма нового оффера
     * @param {*} msgHTMLElement HTML-элемент поля информации
     * @param {*} username HTML-элемент имени пользователя
     * @param {*} event
     */
    add(event) {
      event.preventDefault()
      let formData = new FormData(this.form);
      formData.append("user", this.username);
  
      fetch(this.URL, { method: "post", body: formData })
        .then((response) => response.text())
        .then((data) => {
          try {
            let offer = JSON.parse(data);

            if (offer.result == 1) {
              event.target.reset()
              this.msgElement.textContent = `${offer.offerName} добавлен`;
            } else {
              this.msgElement.textContent = offer.error;
            }
          } catch (err) {
            if (data.includes("<title>Page Expired</title>")) {
              window.open("/wrong-uri", "_self")
            } else {
              this.msgElement.textContent = err;
            }
          }
        })
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
  }
  