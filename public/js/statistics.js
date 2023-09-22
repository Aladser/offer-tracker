/** CSRF */
const csrfToken = document.querySelector('meta[name="csrf-token"]');
/** переключатель временного периода */
const timeSwitcher = document.querySelector('#time-period-article__switcher');
/** выбор времени */
timeSwitcher.times.forEach(input => input.onclick = e => clickTimePeriod(e));

/** клик на переключатель времени */
function clickTimePeriod(e) {
    let headers = {'X-CSRF-TOKEN': csrfToken.getAttribute('content')};
    let id = e.target.closest('form').querySelector('#time-period-article__input-id').value;
    let data = new URLSearchParams();
    data.set('period', e.target.value);

    fetch(`/advertiser/${id}/money`, {method:'post', headers: headers, body:data}).then(response => response.text()).then(data => {
        console.log(data);
    })
}
