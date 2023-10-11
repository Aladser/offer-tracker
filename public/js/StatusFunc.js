/** Примесь изменения статуса строки */
const statusFunc = {
  /** включить/выключить строку в БД*/
  setStatus(row, inputStatus) {
    let data = new URLSearchParams()
    data.set("id", row.getAttribute("data-id"))
    data.set("status", inputStatus.checked)
    let headers = { "X-CSRF-TOKEN": this.csrfToken.getAttribute("content") }

    let statusSwitch = row.querySelector("input[name='status']")
    fetch(`${this.URL}/status`, {method: "post",headers: headers,body: data,})
      .then((response) => response.text())
      .then((rslt) => {
        if (rslt == 1) {
          statusSwitch.title = inputStatus.checked ? "выключить" : "включить";
        } else {
          if (rslt.includes("<title>Page Expired</title>")) {
              window.open("/wrong-uri", "_self");
          } else {
            this.errorPrg.textContent = "серверная ошибка изменения статуса";
            console.log(rslt);
          }
        }
      })
  }
}
  
  