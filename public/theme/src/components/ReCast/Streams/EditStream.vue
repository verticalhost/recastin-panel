<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4 v-if="$route.params.id == 'add'">Create a new Stream</h4>
                    <h4 v-if="$route.params.id != 'add'">Edit "{{ stream.name }}"</h4>

                    <card>
                        <fg-input label="Name" v-model="stream.name"></fg-input>
                        <div class="form-group">
                            <p-checkbox v-model="stream.active">Active</p-checkbox>
                        </div>

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
                stream: {
                    active: false,
                    name: ''
                }
            }
        },
        mounted() {
            if (this.$route.params.id !== 'add') {
                this.axios.get('/streams/one?id=' + this.$route.params.id).then(response => {
                    this.stream = response.data;
                });
            }
        },
        methods: {
            save: function () {
                this.axios.post('/streams/update', this.stream).then(() => {
                    this.$router.push('/ucp/streams/');
                })
            }
        }
    }

</script>
<style>

</style>
