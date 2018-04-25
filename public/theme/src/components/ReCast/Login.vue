<template>
    <div class="loginWrapper">
        <div class="sidebarBanner"></div>
        <div class="loginForm">
            <h4>Login</h4>

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
                <p-checkbox v-model="rememberMe">Remember Me</p-checkbox>
            </div>

            <button class="btn btn-primary" v-on:click="onLogin">Login</button>
        </div>
    </div>
</template>
<script>
    import PCheckbox from 'src/components/UIComponents/Inputs/Checkbox.vue'
    import Card from 'src/components/UIComponents/Cards/Card.vue'

    export default {
        components: {
            Card,
            PCheckbox
        },
        data() {
            return {
                login: {
                    _username: '',
                    _password: '',
                },
                rememberMe: false,
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
                    rememberMe: this.rememberMe,
                    redirect: {name: 'Overview'},
                    error: () => {
                        const notification = {
                            template: `<span>Login failed</span>`
                        };

                        this.$notify(
                        {
                            component: notification,
                            icon: 'fa fa-exclamation-triangle',
                            horizontalAlign: 'right',
                            verticalAlign: 'top',
                            type: 'danger'
                        });
                    }
                })
            }
        }
    }
</script>
<style>
    .loginWrapper {
        height: 100vh;
        align-items: stretch;
        flex-wrap: nowrap;
        box-sizing: border-box;
        justify-content: flex-start;
        display: flex;
        flex-flow: nowrap;
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    .loginForm {
        flex: 1 0 auto;
        padding: 80px 40px 80px 40px;
    }

    .sidebarBanner {
        background-image: url("/static/img/bg.jpg");
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        height: 100%;
        flex: 4 1 auto;
    }
</style>
