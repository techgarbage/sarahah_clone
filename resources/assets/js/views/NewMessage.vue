<template>
    <div class="container-fluid" style="width: 800px;">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="new-message.php" method="POST" role="form" id="form" @submit.prevent="send">
                            <legend>Send a new message to <strong>{{ user.name }}</strong></legend>

                            <div class="form-group">
                                <label for="content">Leave a constructive message</label>
                                <textarea name="content" id="content" v-model="form.content" class="form-control" rows="5" maxlength="700" placeholder="Your message..." autofocus></textarea>
                            </div>

                            <button type="submit" :disabled="isProcessing" class="btn btn-primary btn-block g-recaptcha" data-sitekey="6LfXvC4UAAAAAKkSguZdwX9E3_lrrMP3bZcD_Isf" data-callback="recaptchaCallback"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { post } from '../helpers/api';

    export default {
        data() {
            return {
                params: {
                    id: this.$route.params // get params in url
                },
                user: {},
                form: {
                    content: '',
                    user_id: this.$route.params.user_id
                },
                error: {},
                isProcessing: false
            }
        },
        created() {
            post('/api/user/detail', this.params)
                .then((res) => {
                    this.user = res.data.result_detail;
                })
        },
        methods: {
            send() {
                this.isProcessing = true;
                this.error = {};
                post('/api/message/send', this.form)
                    .then((res) => {
                        this.isProcessing = false;
                        this.$router.push('/thank-you');
                    })
                    .catch((err) => {
                        console.log(err);
                    })
            }
        }
    }
</script>