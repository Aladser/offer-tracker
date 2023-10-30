/** Фронт-контроллер таблицы */
class OfferThemeTableClientController extends TableClientController {
    /** создать строку таблицы
     *
     * @param {*} data данные из БД
     */
    processData(row, form) {


        form.reset();
        this.table.querySelector("tbody").innerHTML += `
          <tr id="${row.id}" class='table-themes__tr position-relative relative'> 
            <td class='cursor-pointer p-2'>${row.name}</td>
          </tr>
        `;
        this.msgElement.textContent = "";
        // вешаются события клика строки
        this.table.querySelectorAll(`.${this.table.id}__tr`).forEach((row) => {
            row.onclick = (e) => this.click(e.target.closest("tr"));
        });
    }
}
