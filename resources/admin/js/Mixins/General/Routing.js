
export default {
    data() {
        return {
            routePrefix: this.getPrefix()
        }
    },

    methods: {
        currentRoute(method = null, data = null) {
            return route(this.currentRouteStr(method), data);
        },
        currentRouteStr(method = null) {
            return method ?
                    this.routePrefix + method :
                    route().current();
        },

        getPrefix() {
            let prefix = route().current().split('.').slice(0, 2).join('.') + '.'
            return prefix;
        },
        adminRoute(...args) {
            return router(...args);
        },
        frontUrl(url = '') {
            return this.$page.props.config.url + '/' + url;
        },
    }
}
