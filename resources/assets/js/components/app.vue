<template>
    <v-app id="inspire" dark>
        <v-navigation-drawer
                clipped
                fixed
                v-model="drawer"
                app
        >
            <v-list dense>
                <v-list-tile to="/">
                    <v-list-tile-action>
                        <v-icon>movie</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Videos</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile to="/rules">
                    <v-list-tile-action>
                        <v-icon>bookmark</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Rules</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile to="/settings">
                    <v-list-tile-action>
                        <v-icon>settings</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Settings</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar app fixed clipped-left>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>Pi Local Downloader</v-toolbar-title>
        </v-toolbar>
        <v-content>
            <v-container fluid fill-height>
                <v-layout justify-center align-center>
                    <router-view></router-view>
                </v-layout>
            </v-container>
        </v-content>
        <v-footer app fixed>
            <span>&copy; 2017</span>
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        data: () => ({
            drawer: true
        }),
        props: {
            source: String
        },
        http: {
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        }
    }
</script>
