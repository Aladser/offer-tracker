/** таблица тем */
const userTable = document.querySelector('#table-users');

/** поле результата добавления */
const msgPrg = document.querySelector('#form-add-error');

/** форма создания оффера */
const addUserForm = document.querySelector('#form-add-user');

/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');

/** фронт-контроллер таблицы тем */
const userService = new FrontController('/users', userTable, msgPrg, addUserForm, csrfToken);


/** кнопка отправки формы добавления пользователя */
const addUserButton = document.querySelector('#form-add-user__btn-submit');

const nameInput = addUserForm.querySelector('input[name="name"]');
const emailInput = addUserForm.querySelector('input[name="email"]');
const passwordInput1 = addUserForm.querySelector('input[name="password1"]');
const passwordInput2 = addUserForm.querySelector('input[name="password2"]');

nameInput.oninput = input;
emailInput.oninput = input;
passwordInput1.oninput = input;
passwordInput2.oninput = input;

/** проверить форму добавления пользователя */
function input() {
    if (nameInput.value !== '' && emailInput.value !== '' && passwordInput1.value !== '' && passwordInput2.value !== '') {
        addUserButton.disabled = !(passwordInput1.value === passwordInput2.value);
        msgPrg.textContent = passwordInput1.value === passwordInput2.value ? '' : 'Введенные пароли не совпадают';
    } else {
        addUserButton.disabled = true;
    }
}
