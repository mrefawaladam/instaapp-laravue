<template>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-purple-600">InstaApp</h1>

        <button
            @click="logout"
            class="text-gray-600 hover:text-gray-800 flex items-center space-x-2"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5"
                />
            </svg>
            <span>Logout</span>
        </button>
    </div>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$inertia.post("/logout");
        },
    },
};
</script>
