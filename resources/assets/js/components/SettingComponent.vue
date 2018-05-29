<template>
    <v-container fluid>
    <v-alert
            :value="alert"
            type="success"
            transition="scale-transition"
    >
        Settings Updated
    </v-alert>
    <loading-component :value="loading"></loading-component>
    <v-card>
        <v-subheader>Service Settings</v-subheader>
        <v-data-table
                :headers="service_headers"
                :items="items"
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.name }}</td>
                <td class="text-xs-center">
                    <input
                            v-on:change="updateApiKey(props.item.name, props.item.apiKey, this)"
                            v-model="props.item.apiKey"
                            placeholder="enter apikey or link code">
                </td>
                <td class="text-xs-center">
                    <a v-bind:href="props.item.apiLink" target="_blank">Api Link</a>
                </td>
                <td class="text-xs-center">
                    <input type="checkbox" v-model="props.item.enabled" v-on:change="toggleService(props.item)">
                </td>
            </template>
        </v-data-table>
        <v-divider></v-divider>
        <v-subheader>General Settings</v-subheader>
        <v-data-table
                :headers="settings_headers"
                :items="settings"
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.nice_format }} in GB</td>
                <td class="text-xs-center">
                    <input
                            v-on:change="updateSettings(props.item.key, props.item.value, this)"
                            v-model="props.item.value">
                </td>
            </template>
        </v-data-table>
    </v-card>
    </v-container>
</template>

<script>
    export default {
        name: "SettingComponent",
        data () {
            return {
                service_headers: [
                    {text: 'Service', value: 'service', align: 'center'},
                    {text: 'ApiKey', value: 'apikey', align: 'center'},
                    {text: 'Api Key Link', value: 'apikeylink', align: 'center'},
                    {text: 'Enabled', value: 'enabled', align: 'center'},
                ],
                settings_headers: [
                    {text: 'Key', value: 'key', align: 'center'},
                    {text: 'Vaule', value: 'value', align: 'center'},
                ],
                items: [],
                storage_sizes: [10,20,30,40,50,60,70,80,90,100],
                settings: [],
                alert: false,
                loading: false
            }
        },
        mounted: function() {
            this.getServices();
            this.getSettings();
        },
        methods: {
            getServices() {
                let tb = this;
                $.ajax({
                    url: "/api/services",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        // alert("Success");
                        tb.items = data;
                    },
                    error: function() {
                        alert('Failed!');
                    },
                });
            },
            toggleService(service)
            {
                var self = this;
                console.log(service);
                self.loading = true;
                $.ajax({
                    url: "/api/service/" + service.id + "/update",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'enabled' : service.enabled
                    },
                    success: function(data, textStatus, jqXHR) {
                        self.getServices();
                        self.alert = true;
                        setTimeout(self.hideSuccessMessage, 2000)
                        self.loading = false;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                        self.loading = false;

                        if(service.enabled) {
                            service.enabled = false;
                        } else {
                            service.enabled = true;
                        }
                    }
                });
            },
            updateApiKey(service, key)
            {
                var self = this;
                self.loading = true;
                // console.log(service);
                $.ajax({
                    url: "/api/" + service + "/register",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'key' : key
                    },
                    success: function(data, textStatus, jqXHR) {
                        self.getServices();
                        self.alert = true;
                        setTimeout(self.hideSuccessMessage, 2000)
                        self.loading = false;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                        self.loading = false;
                    }
                });
            },
            getSettings()
            {
                var self = this;
                $.ajax({
                    url: "/api/settings",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR) {
                        console.log(data);
                        self.settings = data;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                    }
                });
            },
            updateSettings(key, value)
            {
                var self = this;
                self.loading = true;
                $.ajax({
                    url: "/api/settings",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'key' : key,
                        'value': value
                    },
                    success: function(data, textStatus, jqXHR) {
                        console.log(data);
                        self.settings = data;
                        self.alert = true;
                        setTimeout(self.hideSuccessMessage, 2000)
                        self.loading = false;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                        self.loading = false;
                    }
                });
            },
            hideSuccessMessage()
            {
                var self = this;
                self.alert = false;
            }
        }
    }
</script>

<style scoped>

</style>