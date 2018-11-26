<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group mb-0">
                        <div class="card p-4">
                            <div class="card-body">
                                <form @submit="checkForm"  action="https://vuejs.org/"  method="post">
                                    <h1>Login</h1>
                                    <p class="text-muted">Sign In to your account</p>
                                    <div v-if="errors.length" class="alert alert-danger" role="alert">
                                        <b>Error</b>
                                        <ul>
                                            <li v-for="error in errors">{{ error }}</li>
                                        </ul>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-addon"><i class="icon-user"></i></span>
                                        <input type="text" class="form-control" placeholder="Username" id="username" v-model="username">
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-addon"><i class="icon-lock"></i></span>
                                        <input type="password" class="form-control" placeholder="Password" id="password" v-model="password">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary px-4">Login</button>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button type="button" class="btn btn-link px-0">Forgot password?</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                            <div class="card-body text-center">
                                <div>
                                    <h2>Sign up</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <button type="button" class="btn btn-primary active mt-3">Register Now!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>


<script>
    export default {
        name: 'LoginInit',
        data:function () {
            return {
            errors: [],
            username: null,
            password: null
        }
        },
        methods:{
            checkForm: function (e) {
                //
                var router = this.$router;
                e.preventDefault();
                if (this.username && this.password) {
                    console.log("probando");
                    //return true;
                    router.push('/dashboard')
                }

                this.errors = [];

                if (!this.username) {
                    this.errors.push('Ingrese el usuario.');
                }

                if (!this.password) {
                    this.errors.push('Ingrese contraseña');
                }



            }
        }
    }
</script>
