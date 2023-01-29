export default {

    base_url: '/api',
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        'Content-Type': 'application/json;charset=utf-8',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        // Authorization: 'Bearer ' + localStorage.getItem("user-token"),
    },

    getUrl( url )
    {
        return fetch( url ).then( response => this.toJson(response) );
    },

    get( url )
    {
        return fetch( this.base_url + url, {
                headers: this.headers,
            }).then( response => this.toJson(response) );
    },

    post( url, data )
    {
        return fetch( this.base_url + url, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify( data )
            }).then( response => this.toJson(response) );
    },

    postFile( url, data )
    {
        let headers = Object.assign({}, this.headers);

        delete headers['Content-Type'];

        if (data.constructor.name != 'FormData')
        {
            let fd = new FormData();

            for ( let prop in data ) fd.append( prop, data[prop]);

            data = fd;
        }

        return fetch( this.base_url + url, {
                method: 'POST',
                headers: headers,
                body: data
            }).then( response => this.toJson(response) );
    },

    put( url, data )
    {
        return fetch( this.base_url + url, {
                method: 'PUT',
                headers: this.headers,
                body: JSON.stringify( data )
            }).then( response => response.text() );
    },

    toJson(response)
    {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Something went wrong');
    },

    setToken()
    {
        this.headers.Authorization = 'Bearer ' + localStorage.getItem("user-token");
    },

    setSocketId( socketId )
    {
        this.headers['X-Socket-ID'] = socketId;
    }
}
