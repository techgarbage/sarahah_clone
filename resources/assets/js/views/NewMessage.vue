<template>
    <div class="container" style="width: 800px;">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="new-message.php" method="POST" role="form" id="form">
                            <legend>Send a new message to <strong>Thai</strong></legend>

                            <div class="form-group">
                                <label for="">Leave a constructive message</label>
                                <textarea name="message" class="form-control" rows="5" maxlength="700" placeholder="Your message..." required autofocus></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block g-recaptcha" data-sitekey="6LfXvC4UAAAAAKkSguZdwX9E3_lrrMP3bZcD_Isf" data-callback="recaptchaCallback"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>