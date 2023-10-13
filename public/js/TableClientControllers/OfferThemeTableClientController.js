/** Фронт-контроллер таблицы */
class OfferThemeTableClientController extends TableClientController {
    /** создать строку таблицы
     *
     * @param {*} data данные из БД
     */
    processData(form, data) {
        form.reset();
        this.table.querySelector("tbody").innerHTML += `
      <tr data-id="${data.row.id}" class='table-themes__tr position-relative'> 
        <td>${data.row.name}</td>
      </tr>
    `;
        this.msgElement.textContent = "";
        this.table.querySelectorAll(`.${this.table.id}__tr`).forEach((row) => {
            row.onclick = (e) => this.click(e.target.closest("tr"));
        });
    }
}
