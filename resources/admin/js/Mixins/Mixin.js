import moment from 'moment';

export default {
    data() {
        return {
        }
    },

    methods: {

        frontUrl(url = '') {
            return this.$page.props.config.url + '/' + url;
        },

        formatPrice() {
            let price = [...arguments].reduce((a, b) => parseFloat(a) + parseFloat(b), 0);

            if (price) {
                price = Math.round(price);
                return new Intl.NumberFormat('ru-RU').format(price);
            }
            else
                return 0;
        },

        formatBytes(length, precision = 2) {
            let i = 0,
                type = ['B', 'KB', 'MB', 'GB', 'TB'];

            while((length / 1000 | 0) && i < type.length - 1) {
                length /= 1024;
                i++;
            }

            return length.toFixed(precision) + ' ' + type[i];
        },

        formatSeconds(duration) {
            duration *= 1000; // лень переписыать

            let milliseconds = parseInt((duration % 1000) / 100),
                seconds = Math.floor((duration / 1000) % 60),
                minutes = Math.floor((duration / (1000 * 60)) % 60),
                hours = Math.floor((duration / (1000 * 60 * 60)) % 24);

            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;

            return hours + ":" + minutes + ":" + seconds;
            // + "." + milliseconds;
        },

        formatDateTime(date) {
            moment.locale('ru');
            return moment(date).format('L LT');
        },

        formatDate(date) {
            moment.locale('ru');
            return moment(date).format('L');
        },

        dateToInput(date) {
            if (!date)
                return;
            return moment(date).format('YYYY-MM-DD');
        },

        dateTimeToInput(date) {
            if (!date)
                return;
            return moment(date).format('YYYY-MM-DDTHH:mm');
        },

        inputDateToUTC(date) {
            if (!date)
                return;
            return moment(date).utc().format();
        },

        confirm(e) {
            if (!confirm('Вы уверены?'))
                e.preventDefault()
        }
    }
}
