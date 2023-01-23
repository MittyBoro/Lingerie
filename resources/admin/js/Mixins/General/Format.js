import moment from 'moment';
import 'moment/dist/locale/ru';
moment.locale('ru');


export default {
    data() {
        return {
            routePrefix: this.getPrefix()
        }
    },


    methods: {

        currencyByLang(lang) {
            let key = this.$page.props.currencies[lang]
            return this.currencySymbol(key);
        },

        currencySymbol(key) {
            let val = key;
            if (key == 'usd')
                val = '$'
            else if (key == 'rub')
                val = '₽'
            else
                val = key.toUpperCase()

            return val
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
            return moment(date).format('L LT');
        },

        formatDate(date) {
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
    }
}
