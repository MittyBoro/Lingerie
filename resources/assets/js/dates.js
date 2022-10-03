import moment from 'moment';


function formatDateTime(date) {
	moment.locale('ru');
	return moment.utc(date).local().format('L LT');
}

function formatDate(date) {
	moment.locale('ru');
	return moment.utc(date).local().format('L');
}

document.querySelectorAll('[data-format-date]').forEach(el => {
	el.innerText = formatDate( el.dataset.formatDate );
	el.classList.add('date-ready')
});
document.querySelectorAll('[data-format-datetime]').forEach(el => {
	el.innerText = formatDateTime( el.dataset.formatDatetime );
	el.classList.add('date-ready')
});
