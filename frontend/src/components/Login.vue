<template>
    <div class="flex-column justify-content-center">
        <div v-if="isLoading" class="spinner-overlay">
            <div class="spinner-grow text-primary"></div>
        </div>
        <div v-else>
            <img alt="House Logo" src="@/assets/rentalhousing.png">
            <p>Welcome to the Page</p>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'LoginForm',
        data() {
            return {
                isLoading: true,
            }
        },
        created() {
            setTimeout(() => {
                this.isLoading = false;
                console.log('Flag reset');
            }, 3000);
        }
    };
</script>