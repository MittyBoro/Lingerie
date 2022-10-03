import axios from "axios";

export default class UploadAdapter {
	constructor(loader, editor, url) {
		this.url = url;
		this.loader = loader;
		this.editor = editor;
	}

	upload() {
		return this.loader.file.then(pic => {
			return this._sendRequest( pic )
		});
	}

	_sendRequest( file ) {
		const fd = new FormData();

		fd.append('upload', file);

		let data = this.editor.config.get('fieldData');
		let notify = this.editor.config.get('notify');

		for ( let key in data ) {
			fd.append(key, data[key]);
		}

		return new Promise((resolve, reject) => {
			axios
				.post(this.url, fd)
				.then(response => {
					resolve(response.data);
				})
				.catch(error => {
					reject();

					let errorText = error.response.data.errors ?
											Object.values(error.response.data.errors)[0] : error.message;
					notify.error(errorText);
				});
		});
	}
}
