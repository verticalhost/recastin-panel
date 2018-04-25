<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4 v-if="$route.params.id == 'add'">Create a new Endpoint</h4>
                    <h4 v-if="$route.params.id != 'add'">Edit "{{ endpoint.name }}"</h4>

                    <card>
                        <fg-input label="Name" v-model="endpoint.name"></fg-input>

                        <div class="form-group">
                            <p-checkbox v-model="endpoint.active">Active</p-checkbox>
                        </div>

                        <div class="form-group">
                            <label class="control-label">
                                Type
                            </label>
                            <select class="form-control" v-model="endpoint.type">
                                <option v-for="name in serviceNames" :value="name">{{name}}</option>
                            </select>
                        </div>

                        <div class="form-group" v-if="serverData.length">
                            <label class="control-label">
                                Server
                            </label>
                            <select class="form-control" v-model="endpoint.server">
                                <option v-for="server in serverData" :value="server.value">{{server.name}}</option>
                            </select>
                        </div>

                        <fg-input label="Server" v-model="endpoint.server" v-if="!serverData.length"></fg-input>

                        <fg-input label="Stream-Key" v-model="endpoint.streamKey"></fg-input>

                        <button class="btn btn-primary" v-on:click="save">Save</button>
                    </card>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import PCheckbox from 'src/components/UIComponents/Inputs/Checkbox.vue'
    import Card from 'src/components/UIComponents/Cards/Card.vue'

    export default {
        components: {
            PCheckbox,
            Card
        },
        data() {
            return {
                endpoint: {
                    name: '',
                    active: false,
                    type: 'Mixer',
                    server: '',
                    streamKey: '',
                },
                services: {},
                serviceNames: []
            }
        },
        mounted() {
            this.axios.get('/streams/services').then(response => {
                this.serviceNames = Object.keys(response.data);
                this.services = response.data;
            });

            if (this.$route.params.id !== 'add') {
                this.axios.get('/streams/endpoint/' + this.$route.params.id).then(response => {
                    this.endpoint = response.data;
                });
            }
        },
        methods: {
            save: function () {
                this.axios.post('/streams/' + this.$route.params.streamId + '/endpoints/update', this.endpoint).then(() => {
                    this.$router.push('/ucp/streams/' + this.$route.params.streamId + '/');
                })
            }
        },
        computed: {
            serverData: function () {
                let data =[];
                if (this.endpoint.type.length && this.services[this.endpoint.type]) {
                    let keys = Object.keys(this.services[this.endpoint.type]);
                    keys.forEach(name => {
                        data.push({
                            name: name,
                            value: this.services[this.endpoint.type][name]
                        })
                    });
                }

                return data;
            }
        }
    }
</script>
<style>

</style>
