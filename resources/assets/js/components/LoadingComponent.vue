<template>
    <v-layout row justify-center>
        <v-dialog v-model="value" persistent content content-class="centered-dialog">
            <v-container fill-height>
                <v-layout column justify-center align-center>
                    <fingerprint-spinner :animation-duration="1500" :size="64" :color="progressColor" />
                    <h1 v-if="message != null">{{message}}</h1>
                </v-layout>
            </v-container>
        </v-dialog>
    </v-layout>
</template>
<script>
    import {
        FingerprintSpinner
    } from 'epic-spinners'
    export default {
        name: "Loading",
        components: {
            FingerprintSpinner
        },
        data: function() {
            return {}
        },
        props: {
            value: {
                type: Boolean,
                default: false
            },
            message: {
                type: String,
                default: "Please wait..."
            },
            progressColor: {
                type: String,
                default: '#FFFFFF'
            },
        },
    }
</script>

<style>
    .dialog.centered-dialog {
        background: #282c2dad;
        box-shadow: none;
        border-radius: 6px;
        width: auto;
        color: whitesmoke;
    }
</style>