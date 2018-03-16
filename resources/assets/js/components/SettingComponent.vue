<template>
    <v-card>
        <v-card-title>
            <h1>Settings</h1>
        </v-card-title>
        <v-data-table
                :headers="headers"
                :items="items"
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.name }}</td>
                <td class="text-xs-center">
                    <input v-on:change="updateApiKey(props.item.name, apikey)" v-model="apikey" placeholder="enter apikey or link code">
                </td>
                <td class="text-xs-center">
                    <input type="checkbox" v-model="props.item.enabled" v-on:change="toggleService(props.item)">
                </td>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    export default {
        name: "SettingComponent",
        data () {
            return {
                headers: [
                    {text: 'Service', value: 'service', align: 'center'},
                    {text: 'ApiKey', value: 'apikey', align: 'center'},
                    {text: 'Enabled', value: 'enabled', align: 'center'},
                ],
                items: [],
                apikey: "",
            }
        },
        mounted: function() {
            this.getServices();
        },
        methods: {
            getServices() {
                let tb = this;
                $.ajax({
                    url: "/api/settings/services" ,
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
                $.ajax({
                    url: "/api/settings/" + service.id + "/update",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'enabled' : service.enabled
                    },
                    success: function(data, textStatus, jqXHR) {
                        self.getServices();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);

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
                console.log(service);
                $.ajax({
                    url: "/api/" + service + "/register",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'key' : key
                    },
                    success: function(data, textStatus, jqXHR) {
                        self.getServices();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);

                        if(service.enabled) {
                            service.enabled = false;
                        } else {
                            service.enabled = true;
                        }
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>