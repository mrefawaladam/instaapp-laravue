<template>
    <div class="max-w-4xl mx-auto pt-4 px-4 relative">
        <!-- Top Bar -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-purple-600">InstaApp</h1>
            <button class="text-gray-600 hover:text-gray-800">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-7 h-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v1m0 14v1m8-8h-1M5 12H4m15.364-7.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707"
                    />
                </svg>
            </button>
        </div>

        <!-- User Stories -->
        <div class="flex overflow-x-auto space-x-4 pb-4 mb-6 border-b">
            <div v-for="n in 5" :key="n" class="flex flex-col items-center">
                <div
                    class="w-16 h-16 rounded-full bg-gradient-to-tr from-pink-500 to-yellow-500 p-1"
                >
                    <div
                        class="w-full h-full bg-white rounded-full flex items-center justify-center"
                    >
                        <div class="w-14 h-14 bg-gray-300 rounded-full"></div>
                    </div>
                </div>
                <p class="text-xs mt-2 text-gray-700">User {{ n }}</p>
            </div>
        </div>

        <!-- Create Post Button -->
        <div class="flex justify-end mb-4">
            <button
                class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700"
            >
                Create Post
            </button>
        </div>

        <!-- Feed Posts -->
        <div class="space-y-6">
            <div
                v-for="post in posts"
                :key="post.id"
                class="bg-white rounded-lg shadow-md p-6"
            >
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                    <div class="ml-3">
                        <p class="font-semibold">{{ post.user.name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ formatDate(post.created_at) }}
                        </p>
                    </div>
                </div>
                <img
                    :src="`/storage/${post.image_url}`"
                    alt="Post Image"
                    class="w-full rounded-lg mb-4"
                />
                <div class="flex items-center mb-2">
                    <button
                        @click="likePost(post)"
                        :class="[
                            'flex items-center space-x-2',
                            post.liked ? 'text-pink-500' : 'text-gray-400',
                        ]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-7 h-7 transition-transform duration-300 transform"
                            :class="{ 'scale-125': post.animating }"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            stroke="currentColor"
                        >
                            <path
                                v-if="post.liked"
                                fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L12 8.343l3.172-3.171a4 4 0 115.656 5.656L12 21.828l-8.828-8.828a4 4 0 010-5.656z"
                                clip-rule="evenodd"
                            />
                            <path
                                v-else
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.682l-7.682-7.682a4.5 4.5 0 010-6.364z"
                            />
                        </svg>
                        <span>Like</span>
                    </button>
                    <span class="ml-4 text-gray-500"
                        >{{ post.likes_count }} likes</span
                    >
                </div>

                <div class="text-gray-800">
                    <p v-if="post.caption" class="font-semibold">
                        {{ post.user.name }}:
                    </p>
                    <p v-if="post.caption">{{ post.caption }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        posts: Array,
    },
    methods: {
        formatDate(date) {
            return new Date(date).toLocaleString();
        },
        async likePost(post) {
            if (post.liking) return; // Cegah spam click

            const originalLiked = post.liked;
            const originalLikesCount = post.likes_count;

            // Optimistic UI update
            post.liking = true;
            post.liked = !post.liked;
            post.likes_count += post.liked ? 1 : -1;
            post.animating = true;
            setTimeout(() => {
                post.animating = false;
            }, 300);

            try {
                await this.$inertia.post(
                    `/posts/${post.id}/like`,
                    {},
                    {
                        preserveState: true,
                        only: ["posts"], // optional: biar payload inertia kecil
                    }
                );
            } catch (e) {
                console.error("Failed to like/unlike:", e);
                // Rollback kalau error
                post.liked = originalLiked;
                post.likes_count = originalLikesCount;
            } finally {
                post.liking = false;
            }
        },
    },
};
</script>
