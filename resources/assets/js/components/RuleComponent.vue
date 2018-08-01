<template>
    <v-container fluid>
    <loading-component :value="loading"></loading-component>
    <v-card>
        <v-card-title>
            <input v-model="rule" placeholder="New Rule">
            <v-btn v-on:click.native='addRule(this, rule)' block flat color="green">
                <v-icon left class="material-icons">add_box</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-text-field
                    append-icon="search"
                    label="Search"
                    single-line
                    hide-details
                    v-model="search"
            ></v-text-field>
        </v-card-title>
        <v-data-table
                :headers="headers"
                :items="items"
                :search="search"
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.rule }}</td>
                <td class="text-xs-center">
                    <input type="checkbox" v-model="props.item.enabled" v-on:change="toggleRule(props.item)">
                </td>
                <td class="text-xs-center">
                    <v-btn v-on:click.native='deleteRule(this, props.item)' block flat color="red">
                        <v-icon left class="material-icons">delete</v-icon>
                    </v-btn>
                </td>
            </template>
            <v-alert slot="no-results" :value="true" color="error" icon="warning">
                Your search for "{{ search }}" found no results.
            </v-alert>
        </v-data-table>
    </v-card>
    </v-container>
</template>

<script>
    export default {
        name: "RuleComponent",
        data () {
            return {
                search: '',
                headers: [
                    {text: 'Rule', value: 'rule', align: 'center'},
                    {text: 'Enabled', value: 'enabled', align: 'center'},
                    {text: 'Delete', value: 'delete', sortable: false, align: 'center'},
                ],
                items: [],
                rule: '',
                loading: false,
            }
        },
        mounted: function () {
            this.getData();
        },
        methods: {
            getData() {
                var self = this;
                self.loading = true;
                $.ajax({
                    url: "/api/rules/all" ,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        // alert("Success");
                        self.items = data;
                        self.loading = false;
                    },
                    error: function() {
                        alert('Failed!');
                        self.loading = false;
                    },
                });
            },
            deleteRule(event, rule) {
                var self = this;
                self.loading = true;
                $.ajax({
                    url: "/api/rule/" + rule.id + "/delete",
                    type: 'POST',
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR) {
                        self.getData();
                        self.loading = false;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                        self.loading = false;
                    }
                })
            },
            toggleRule(rule)
            {
                var self = this;
                self.loading = true;
                console.log(rule);
                $.ajax({
                    url: "/api/rule/" + rule.id + "/update",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'enabled' : rule.enabled
                    },
                    success: function(data, textStatus, jqXHR) {
                        self.getData();
                        self.loading = false;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                        self.loading = false;
                        if(rule.enabled) {
                            rule.enabled = false;
                        } else {
                            rule.enabled = true;
                        }
                    }
                });
            },
            addRule(event, rule)
            {
                var self = this;
                self.loading = true;
                $.ajax({
                    url: "/api/rule/add",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'rule' : rule
                    },
                    success: function(data, textStatus, jqXHR) {
                        self.loading = false;
                        self.getData();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                        self.loading = false;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>