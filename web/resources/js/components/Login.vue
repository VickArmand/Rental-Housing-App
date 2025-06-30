<template>
    <div class="container">
        <div v-if="pageLoad" class="spinner-overlay">
            <div class="spinner-grow text-primary"></div>
        </div>
        <div v-else>
            <img alt="House Logo" src="@/assets/rentalhousing.png" />
            <form
                @submit.prevent="handleSubmit"
                class="d-flex flex-column align-items-center"
            >
                <div
                    class="d-flex justify-content-between align-items-center gx-3 py-3"
                >
                    <label for="loginEmail" class="form-label col"
                        >Email:</label
                    >
                    <input
                        type="email"
                        class="form-control col"
                        id="loginEmail"
                        placeholder="Enter your email"
                        v-model="formData.email"
                        :class="{ 'is-invalid': errors.email }"
                    />
                    <div class="invalid-feedback" v-if="errors.email">
                        {{ errors.email }}
                    </div>
                </div>
                <div
                    class="d-flex justify-content-between align-items-center gx-3 py-3"
                >
                    <label for="loginPassword" class="form-label col"
                        >Password:</label
                    >
                    <input
                        type="password"
                        class="form-control col"
                        name=""
                        id="loginPassword"
                        placeholder="Enter your password"
                        v-model="formData.password"
                        :class="{ 'is-invalid': errors.password }"
                    />
                    <div class="invalid-feedback" v-if="errors.password">
                        {{ errors.password }}
                    </div>
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
            <div v-if="!isLoading">
                <ToastComponent title="LOGIN" message="Login Success" />
            </div>
        </div>
    </div>
</template>
<script>
import { emailRule, minLengthLimit } from "@/rules/FormRules";
import { apipost } from "@/utils/RequestMethods";
import ToastComponent from "./toasts/Toast.vue";

export default {
    name: "LoginForm",
    components: {
        ToastComponent,
    },
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
            },
            loginUrl: `${import.meta.env.VITE_APP_API_URL}/api/login/`,
            response: null,
        };
    },
    created() {
        setTimeout(() => {
            this.pageLoad = false;
        }, 3000);
    },
    methods: {
        validateForm() {
            let res = emailRule(this.formData.email);
            this.errors.email = res !== true ? res : "";
            res = minLengthLimit(8)(this.formData.password);
            this.errors.password = res !== true ? res : "";
            if (this.errors.email || this.errors.password) return false;
            return true;
        },
        async handleSubmit() {
            this.isLoading = true;
            if (this.validateForm())
                this.response = await apipost(this.loginUrl, this.formData);
            this.isLoading = false;
        },
    },
};
</script>
