export default {

    base_url: '/api',
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        'Content-Type': 'application/json;charset=utf-8',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        // Authorization: 'Bearer ' + localStorage.getItem("user-token"),
    },

    fetchArgs( ...args )
    {
        return fetch( ...args ).then( response => {
            if (response.ok) {
                return response;
            }
            throw new Error('Something went wrong');
        } );
    },

    getUrl( url )
    {
        return this.fetchArgs( url ).then( response => response.json() );
    },

    get( url )
    {
        return this.fetchArgs( this.base_url + url, {
                headers: this.headers,
            }).then( response => response.json() );
    },

    post( url, data )
    {
        return this.fetchArgs( this.base_url + url, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify( data )
            }).then( response => response.json() );
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

        return this.fetchArgs( this.base_url + url, {
                method: 'POST',
                headers: headers,
                body: data
            }).then( response => response.json() );
    },

    put( url, data )
    {
        return this.fetchArgs( this.base_url + url, {
                method: 'PUT',
                headers: this.headers,
                body: JSON.stringify( data )
            }).then( response => response.text() );
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
