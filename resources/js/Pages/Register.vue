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

            <!-- Success Message -->
            <div
                v-if="successMessage"
                class="p-4 text-green-700 bg-green-100 rounded"
            >
                {{ successMessage }}
            </div>

            <form @submit.prevent="register" class="space-y-4">
                <input
                    v-model="name"
                    3
                    type="text"
                    placeholder="Name"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                    :class="{ 'border-red-500': errors.name }"
                    required
                />
                <p v-if="errors.name" class="text-red-500 text-sm">
                    {{ errors.name }}
                </p>

                <input
                    v-model="email"
                    type="email"
                    placeholder="Email"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                    :class="{ 'border-red-500': errors.email }"
                    required
                />
                <p v-if="errors.email" class="text-red-500 text-sm">
                    {{ errors.email }}
                </p>

                <input
                    v-model="password"
                    type="password"
                    placeholder="Password"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                    :class="{ 'border-red-500': errors.password }"
                    required
                />
                <p v-if="errors.password" class="text-red-500 text-sm">
                    {{ errors.password }}
                </p>

                <input
                    v-model="password_confirmation"
                    type="password"
                    placeholder="Confirm Password"
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                />

                <button
                    type="submit"
                    class="w-full py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700"
                >
                    Sign Up
                </button>
            </form>

            <p class="text-center text-sm text-gray-600">
                Already have an account?
                <a href="/login" class="text-purple-600 hover:underline">
                    Log in
                </a>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            successMessage: "",
        };
    },
    computed: {
        errors() {
            return this.$page.props.errors || {};
        },
    },
    methods: {
        async register() {
            try {
                await this.$inertia.post(
                    "/register",
                    {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    },
                    {
                        onSuccess: () => {
                            this.successMessage =
                                "Registration successful! Please log in.";
                            this.name = "";
                            this.email = "";
                            this.password = "";
                            this.password_confirmation = "";
                        },
                    }
                );
            } catch (e) {
                console.error(e);
            }
        },
    },
};
</script>
