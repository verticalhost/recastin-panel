<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bg-white p-3">
                        <a class="btn btn-primary mb-3" :href="'#/ucp/streams/' + $route.params.id + '/endpoints/add'">Add a new Endpoint</a>

                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Service</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="endpoint in endpoints">
                                    <td>{{ endpoint.name }}</td>
                                    <td>{{ endpoint.type }}</td>
                                    <td>{{ endpoint.server }}</td>
                                    <td>
                                        <a :href="'#/ucp/streams/' + $route.params.id + '/endpoints/' + endpoint.id" class="btn btn-secondary">Edit</a>
                                        <a v-on:click="deleteEndpoint(endpoint)" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                endpoints: []
            }
        },
        mounted() {
            this.axios.get('/streams/' + this.$route.params.id + '/endpoints/').then(response => {
                this.endpoints = response.data;
            });
        },
        methods: {
            deleteEndpoint: function (endpoint) {
                this.endpoints.splice(this.endpoints.indexOf(endpoint), 1);
                this.axios.post('/streams/deleteEndpoint', {id: endpoint.id});
            }
        }
    }
</script>
<style>

</style>
