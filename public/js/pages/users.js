/** таблица тем */
const userTable = document.querySelector('#table-users');

/** поле результата добавления */
const msgPrg = document.querySelector('#form-add-error');

/** форма создания оффера */
const addUserForm = document.querySelector('#form-add-user');

/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');

/** фрон-контроллер таблицы тем */
const userService = new UserService('/offer-theme', userTable, msgPrg, addUserForm, csrfToken);