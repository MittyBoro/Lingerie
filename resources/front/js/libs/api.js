export default {

    base_url: '/api',
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        'Content-Type': 'application/json;charset=utf-8',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        // Authorization: 'Bearer ' + localStorage.getItem("user-token"),
    },

    fetchArgs( ...args ) {
        return fetch( ...args )
                .then( response => {
                    if (response.ok) {
                        return response;
                    }
                    throw new Error('Something went wrong');
                } )
    },

    get( url, raw = false ) {
        return this.fetchArgs( this.base_url + url, {
                headers: this.getHeaders(raw),
            }).then( response => this.getResponse(response, raw) );
    },


    post( url, data, raw = false ) {
        return this.fetchArgs( this.base_url + url, {
                method: 'POST',
                headers: this.getHeaders(raw),
                body: JSON.stringify( data )
            }).then( response => this.getResponse(response, raw) );
    },

    postFile( url, data ) {
        let headers = Object.assign({}, this.getHeaders());

        delete headers['Content-Type'];

        if (data.constructor.name != 'FormData')
        {
            let fd = new FormData();

            for ( let prop in data ) fd.append( prop, data[prop]);

            data = fd;
        }

        return this.fetchArgs( this.base_url + url, {
                method: 'POST',
                headers: headers,
                body: data
            }).then( response => this.getResponse(response) );
    },

    put( url, data ) {
        return this.fetchArgs( this.base_url + url, {
                method: 'PUT',
                headers: this.getHeaders(),
                body: JSON.stringify( data )
            }).then( response => this.getResponse(response, true) );
    },

    getResponse(response, raw = false) {
        return raw ? response.text() : response.json()
    },

    getHeaders(raw = false) {
        return raw ? {
            ...this.headers,
            'Content-Type': 'text/html;charset=utf-8',
        } : this.headers
    },

    setToken() {
        this.headers.Authorization = 'Bearer ' + localStorage.getItem("user-token");
    },

    setSocketId( socketId ) {
        this.headers['X-Socket-ID'] = socketId;
    }
}
