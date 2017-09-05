<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-info">
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Total: <strong id="count">{{ messages.length }}</strong> messages received.
                    <social-sharing url="https://vuejs.org/" inline-template>
                        <div>
                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                            <network network="facebook" style="cursor: pointer;">
                                <i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook
                            </network>
                            <network network="googleplus" style="cursor: pointer;">
                                <i class="fa fa-google-plus-square" aria-hidden="true"></i> Google +
                            </network>
                            <network network="pinterest" style="cursor: pointer;">
                                <i class="fa fa-pinterest-square" aria-hidden="true"></i> Pinterest
                            </network>
                            <network network="twitter" style="cursor: pointer;">
                                <i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter
                            </network>
                        </div>
                    </social-sharing>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Messages</h3>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-warning" v-if="messages.length == 0">
                            <strong>Oh NO!</strong> You have not received any messages yet.
                        </div>
                        <ul class="media-list" id="messages" v-for="message in messages">
                            <li class="media" id="message">
                                <div class="media-left">
                                    <img class="media-object" src="../../../../public/images/message.png" alt="message" width="64" height="64">
                                </div>
                                <div class="media-body">
                                    <button type="button" class="close" aria-label="Delete" :data-id="message.id"><span aria-hidden="true">&times;</span></button>
                                    <button type="button" class="close" aria-label="Delete" :data-id="message.id"><span aria-hidden="true">&times;</span></button>
                                    <blockquote>
                                        <p class="message-content">{{ message.content }}</p>
                                        <footer>Anonymous at {{ message.created_at }}</footer>
                                    </blockquote>
                                </div>
                                <hr>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { post } from '../helpers/api';

    import Auth from '../store/auth';

    import SocialSharing from 'vue-social-sharing';

    export default {
        created() {
            Auth.initialize();
        },
        data() {
            return {
                params: {
                    user_id: this.$route.params,
                    token: Auth.get()
                },
                messages: []
            };
        },
        created() {
            post('/api/message/', this.params)
                .then((res) => {
                    console.log(res);
                    this.messages = res.data.result_detail;
                    console.log(this.messages);
                })
                .catch((err) => {
                    console.log(err);
                })
        },
        components: {
            SocialSharing
        }
    }
</script>