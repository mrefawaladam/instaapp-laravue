<template>
    <div
        class="flex justify-center items-center min-h-screen bg-gradient-to-r from-purple-500 to-pink-500"
    >
        <div
            class="w-full max-w-lg bg-white rounded-lg shadow-md p-8 space-y-6"
        >
            <h1 class="text-3xl font-semibold text-center text-gray-800">
                InstaApp
            </h1>

            <!-- Tampilkan error global -->
            <div v-if="errors.email" class="text-red-500 text-sm text-center">
                {{ errors.email }}
            </div>

            <form @submit.prevent="login" class="space-y-4">
                <div>
                    <input
                        v-model="email"
                        type="email"
                        placeholder="Email"
                        class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                        required
                    />
                </div>
                <div>
                    <input
                        v-model="password"
                        type="password"
                        placeholder="Password"
                        class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700"
                >
                    Log In
                </button>
            </form>

            <p class="text-center text-sm text-gray-600">
                Don't have an account?
                <a href="/register" class="text-purple-600 hover:underline"
                    >Sign up</a
                >
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        errors: Object,
    },
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        async login() {
            await this.$inertia.post("/login", {
                email: this.email,
                password: this.password,
            });
        },
    },
};
</script>
