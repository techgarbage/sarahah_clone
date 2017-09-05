<template>
    <div class="container-fluid" style="width: 600px;">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">User Register</h3>
                    </div>
                    <div class="panel-body">
                        <form action="" method="POST" role="form" @submit.prevent="register">

                            <div class="form-group">
                                <label for="email"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Email</label>
                                <input type="text" class="form-control" name="email" id="email" v-model="form.email" placeholder="Your email...">
                            </div>

                            <div class="form-group">
                                <label for="name"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Name</label>
                                <input type="text" class="form-control" name="name" id="name" v-model="form.name" placeholder="Your name...">
                            </div>

                            <div class="form-group">
                                <label for="password"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Password</label>
                                <input type="password" class="form-control" name="password" id="password" v-model="form.password" placeholder="Your password...">
                            </div>

                            <div class="form-group">
                                <label for="password"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" v-model="form.password_confirmation" placeholder="Your confirmation password...">
                            </div>

                            <button :disable="isProcessing" class="btn btn-primary"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Register</button>
                            <button class="btn btn-danger"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span><router-link to="/" style="color: #ffffff;"> Back</router-link></button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Flash from '../helpers/flash';

    import { post } from '../helpers/api';

    export default {
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                error: {},
                isProcessing: false
            }
        },
        methods: {
            register() {
                this.isProcessing = true;
                this.error = {};
                post('/api/user/register', this.form)
                    .then((res) => {
                        console.log(res);
                        if(res.data.result_code === '0') {
                            Flash.setSuccess('Congratulations! You have now successfully registered.');
                            this.$router.push('/login');
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