<template>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Left Section (Login/Register) -->
        <div class="w-full max-w-md p-8 space-y-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-6">InstaApp</h1>

                <!-- Login Form -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <LoginForm />
                </div>

                <!-- Signup Form -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <SignupForm />
                </div>
            </div>
        </div>

        <!-- Right Section (Feed) -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-2xl mx-auto space-y-6">
                <!-- New Post Button -->
                <div class="flex justify-end">
                    <button
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                    >
                        New Post
                    </button>
                </div>

                <!-- Post Cards -->
                <PostCard />
                <PostCard />
                <PostCard />
            </div>
        </div>
    </div>
</template>

<script>
import LoginForm from "@/Components/LoginForm.vue";
import SignupForm from "@/Components/SignupForm.vue";
import PostCard from "@/Components/PostCard.vue";

export default {
    components: {
        LoginForm,
        SignupForm,
        PostCard,
    },
    data() {
        return {
            posts: [],
        };
    },
    mounted() {
        this.fetchPosts();
    },
    methods: {
        fetchPosts() {
            // Gantilah dengan pemanggilan API yang sesuai
            axios
                .get("/api/posts")
                .then((response) => {
                    this.posts = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
