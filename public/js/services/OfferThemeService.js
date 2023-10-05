/** Фронт-контроллер таблицы */
class OfferThemeService extends FrontController{
  /** создать строку таблицы
   * 
   * @param {*} data данные из БД
   */
  createRow(data) {
    this.table.querySelector("tbody").innerHTML 
      += `<tr data-id="${data.row.id}" class='table-themes__tr position-relative'>`
      +`<td>${data.row.name}</td>`
      +"</tr>";
  }
}
