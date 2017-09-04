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
                    <li><router-link to="/register">Register</router-link></li>
                    <li><router-link to="/login">Login</router-link></li>
                    <li><a href="">About</a></li>
                    <li><a href="https://m.me/manhtuan1412" target="_blank">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
</template>