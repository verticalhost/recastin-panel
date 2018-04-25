<template>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <card>
                        <div class="alert alert-danger" v-if="authFailed">Bad credentials</div>

                        <fg-input type="text"
                                  label="Username"
                                  placeholder="Username"
                                  v-model="login._username">
                        </fg-input>

                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" class="form-control" placeholder="Password" v-model="login._password">
                        </div>
                        <div class="form-group">
                            <div class="peers ai-c jc-sb fxw-nw">
                                <div class="peer">
                                    <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                                        <input type="checkbox" id="inputCall1" name="inputCheckboxesCall" class="peer">
                                        <label
                                                for="inputCall1" class="peers peer-greed js-sb ai-c"><span class="peer peer-greed">Remember Me</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="peer">
                                    <button class="btn btn-primary" v-on:click="onLogin">Login</button>
                                </div>
                            </div>
                        </div>
                    </card>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Card from 'src/components/UIComponents/Cards/Card.vue'

    export default {
        components: {
            Card
        },
        data() {
            return {
                login: {
                    _username: 'Shyim',
                    _password: '1',
                },
                authFailed: false
            }
        },
        methods: {
            onLogin: function () {
                let bodyFormData = new FormData();
                bodyFormData.set('_username', this.login._username);
                bodyFormData.set('_password', this.login._password);

                this.$auth.login({
                    data: bodyFormData,
                    rememberMe: true,
                    redirect: {name: 'Overview'}
                })
            }
        }
    }
</script>
<style>

</style>
