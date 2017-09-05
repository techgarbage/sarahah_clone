<template>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <router-link to="/" class="navbar-brand" title="Sarahah">Sarahah</router-link>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li v-if="!auth"><router-link to="/register">Register</router-link></li>
                    <li v-if="!auth"><router-link to="/login">Login</router-link></li>
                    <li v-if="auth"><a @click.stop="logout" style="cursor: pointer;">Logout</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="https://m.me/manhtuan1412" target="_blank">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import Auth from '../store/auth';

    import { post } from '../helpers/api';

    import Flash from '../helpers/flash';

    export default {
        created() {
            Auth.initialize();
        },
        data() {
            return {
                authState: Auth.state,
                params: {
                    token: Auth.state.api_token
                }
            }
        },
        computed: {
            auth() {
                if (this.authState.api_token) {
                    return true;
                }

                return false;
            }
        },
        methods: {
            logout() {
                post('/api/user/logout', this.params)
                    .then((res) => {
                        console.log(res);
                        if(res.data.result_code === '0') {
                            // remove token
                            Auth.remove();
                            Flash.setSuccess('You have successfully logged out.');
                            this.$router.push('/');
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    })
            }
        }
    }
</script>