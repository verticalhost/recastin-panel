<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3>Setup</h3>

                    <fg-input label="URL" v-model="stream.streamUrl" disabled="true"></fg-input>
                    <fg-input label="Stream Key" v-model="stream.streamKey" disabled="true"></fg-input>

                    <h4>OBS</h4>

                    <ul>
                        <li>Go to File, Settings, Stream and choose as Stream Type "Custom Streaming Server"</li>
                        <li>Fill the Server and Stream Key in</li>
                    </ul>
                    <img src="https://i.imgur.com/ltaKXiy.png"/>

                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                stream: {}
            }
        },
        mounted() {
            this.axios.get('/streams/one?id=' + this.$route.params.id).then(response => {
                this.stream = response.data;
            });
        }
    }

</script>
<style>

</style>
