export default {
	state: {
		api_token: null
	},
	initialize() {
		this.state.api_token = localStorage.getItem('api_token');
	},
	set(api_token) {
		localStorage.setItem('api_token', api_token);
		this.initialize();
	},
	get() {
        return localStorage.getItem('api_token');
	},
	remove() {
		localStorage.removeItem('api_token');
		this.initialize();
	}
}
