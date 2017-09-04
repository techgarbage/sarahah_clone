<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-info">
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Total: <strong id="count"><?php echo $count; ?></strong> messages received.
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
                        <!--<?php if ($count === 0): ?>-->
                        <div class="alert alert-warning">
                            <strong>Oh NO!</strong> You have not received any messages yet.
                        </div>
                        <!--<?php else: ?>-->
                        <ul class="media-list" id="messages">
                            <!--<?php foreach ($messages as $message): ?>-->
                            <li class="media" id="message-<?php echo $message['id']; ?>">
                                <div class="media-left">
                                    <img class="media-object" src="images/message.png" alt="message" width="64" height="64">
                                </div>
                                <div class="media-body">
                                    <button type="button" class="close" aria-label="Delete" data-id="<?php echo $message['id']; ?>"><span aria-hidden="true">&times;</span></button>
                                    <!-- <span class="message-content">...</span> -->
                                    <blockquote>
                                        <p class="message-content"><?php echo clean($message['content']); ?></p>
                                        <footer>Anonymous at <?php echo formatTime($message['timestamp']); ?></footer>
                                    </blockquote>
                                </div>
                                <hr>
                            </li>
                            <!--<?php endforeach; ?>-->
                        </ul>
                        <!--<?php endif; ?>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>