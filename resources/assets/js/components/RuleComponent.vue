<template>
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
            }
        },
        mounted: function () {
            this.getData();
        },
        methods: {
            getData() {
                let tb = this;
                tb.loading = true;
                $.ajax({
                    url: "/api/rules/all" ,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        // alert("Success");
                        tb.items = data;
                        tb.loading = false;
                    },
                    error: function() {
                        alert('Failed!');
                    },
                });
            },
            deleteRule(event, rule) {
                var self = this;
                $.ajax({
                    url: "/api/rule/" + rule.id + "/delete",
                    type: 'POST',
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR) {
                        self.getData();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                    }
                })
            },
            toggleRule(rule)
            {
                var self = this;
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
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);

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
                $.ajax({
                    url: "/api/rule/add",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'rule' : rule
                    },
                    success: function(data, textStatus, jqXHR) {
                        self.getData();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>