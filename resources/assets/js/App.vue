<template>
    <main>
        <header class="container-fluid">
            <nav-bar></nav-bar>
        </header>
        <section class="container" style="margin-top: 100px;">
            <div class="row">
                <div class="alert alert-danger alert-block" v-if="flash.error">
                    {{ flash.error }}
                </div>
                <div class="alert alert-success alert-block" v-if="flash.success">
                    {{ flash.success }}
                </div>
            </div>
            <router-view></router-view>
        </section>
    </main>
</template>

<script>
    import Flash from './helpers/flash';

    import NavBar from './components/NavBar.vue';

    import { post } from './helpers/api';

    import Auth from './store/auth';

    export default {
        created() {
            Auth.initialize();
        },
        data() {
            return {
                flash: Flash.state,
                params: {
                    token: Auth.get()
                }
            }
        },
        components: {
            NavBar
        },
        created() {
            post('/api/user/authenticate', this.params)
                .then((res) => {
                    console.log(res);
                    if (res.data.result_code === '0') {
                        this.$router.push('/messages/' + res.data.result_detail.user.id)
                    }
                    if (res.data.result_code === '8') {
                        this.$router.push('/');
                    }
                })
                .catch((err) => {
                    console.log(err);
                })
        }
    }
</script>