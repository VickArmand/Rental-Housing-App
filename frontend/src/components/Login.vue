<template>
    <div class="container">
        <div v-if="pageLoad" class="spinner-overlay">
            <div class="spinner-grow text-primary"></div>
        </div>
        <div v-else>
            <img alt="House Logo" src="@/assets/rentalhousing.png">
            <form @submit.prevent="handleSubmit" class="col-12">
                <div class="row">
                    <label for="loginEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="loginEmail" placeholder="Enter your email" v-model="formData.email">
                </div>
                <div class="row">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" name="" id="loginPassword" placeholder="Enter your password" v-model="formData.password">
                </div>
                <button class="btn btn-primary" type="submit">
                    <div v-if="isLoading">
                        <span class="spinner-border spinner-border-sm"></span>
                        <span>Loading</span>
                    </div>
                    <div v-else>
                        <span>LOGIN</span>
                    </div>
                </button>
                <p class="text-center">
                    <a href="http://">Forgot password</a>
                </p>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'LoginForm',
        data() {
            return {
                pageLoad: true,
                isLoading: false,
                formData: {
                    email: "",
                    password: "",
                },
                errors: {
                    email: "",
                    password: "",
                }
            }
        },
        created() {
            setTimeout(() => {
                this.pageLoad = false;
            }, 3000);
        },
        methods: {
            handleSubmit() {

            }
        }
    };
</script>