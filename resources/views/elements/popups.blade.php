<div class="d-none">

    @if ( $props['show_popup'] ?? null )

    <div class="popup-form popup-1 popup-order-form">
        <div class="h2">Открой студию AleVi по франшизе со скидкой 50% на любой пакет</div>
        <div class="subtitle">и зарабатывай от 150.000 уже на 2 месяц работы</div>
        <form @submit.prevent="submit" class="form">
            <input type="hidden" :value="form.form = 'popup_1'">
            <div class="f-wrap">
                <input placeholder="text" type="text" autocomplete="name" v-model="form.name" required>
                <div class="f-placeholder">Ваше имя</div>
                @svg('images/svg/user.svg')
            </div>
            <div class="space"></div>
            <div class="f-wrap">
                <input placeholder="text" type="text" autocomplete="tel" v-model="form.phone" required>
                <div class="f-placeholder">Ваш телефон</div>
                @svg('images/svg/phone.svg')
            </div>
            <div class="space"></div>
            <button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
                <span :class="{ hidden: success }">Оставить заявку</span>
                <span :class="{ hidden: !success }">Заявка принята</span>
            </button>
        </form>
    </div>

    <div class="popup-form popup-2 popup-order-form">
        <div class="h2">Создай свой бренд с AleVi с минимальной суммой заказа от 20.000</div>
        <form @submit.prevent="submit" class="form">
            <input type="hidden" :value="form.form = 'popup_2'">
            <div class="f-wrap">
                <input placeholder="text" type="text" autocomplete="name" v-model="form.name" required>
                <div class="f-placeholder">Ваше имя</div>
                @svg('images/svg/user.svg')
            </div>
            <div class="space"></div>
            <div class="f-wrap">
                <input placeholder="text" type="text" autocomplete="tel" v-model="form.phone" required>
                <div class="f-placeholder">Ваш телефон</div>
                @svg('images/svg/phone.svg')
            </div>
            <div class="space"></div>
            <button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
                <span :class="{ hidden: success }">Оставить заявку</span>
                <span :class="{ hidden: !success }">Заявка принята</span>
            </button>
        </form>
    </div>

    @endif

</div>
