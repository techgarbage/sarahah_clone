<template>
    <div class="container" style="width: 600px;">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">User Login</h3>
                    </div>
                    <div class="panel-body">
                        <form action="" method="POST" role="form" @submit.prevent="login">
                            <div class="form-group">
                                <label for="email"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Email</label>
                                <input type="text" class="form-control" name="email" id="email" v-model="form.email" placeholder="Your username..." autofocus>
                            </div>

                            <div class="form-group">
                                <label for="password"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Password</label>
                                <input type="password" class="form-control" name="password" id="password" v-model="form.password" placeholder="Your password...">
                            </div>

                            <button type="submit" :disabled="isProcessing" class="btn btn-primary"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</button>
                            <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span><router-link to="/" style="color: #ffffff;"> Back</router-link></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Flash from '../helpers/flash';

    import Auth from '../store/auth';

    import { post } from '../helpers/api';

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error: {},
                isProcessing: false
            }
        },
        methods: {
            login() {
                this.isProcessing = true;
                this.error = {};
                post('/api/user/login ', this.form)
                    .then((res) => {
                        console.log(res);
                        if (res.data.result_code === '0') {
                            Auth.set('123456', res.data.id);
                            Flash.setSuccess('You have successfully logged in.');
                            this.$router.push('/');
                        }
                        if(res.data.result_code === '9') {
                            Flash.setError('Error');
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        console.log(err);
                    })
            }
        }
    }
</script>