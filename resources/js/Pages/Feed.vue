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
                <!-- User info -->
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                    <div class="ml-3">
                        <p class="font-semibold">{{ post.user.name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ formatDate(post.created_at) }}
                        </p>
                    </div>
                </div>

                <!-- Post image -->
                <img
                    :src="`/storage/${post.image_url}`"
                    alt="Post Image"
                    class="w-full rounded-lg mb-4"
                />

                <!-- Like button -->
                <div class="flex items-center mb-2">
                    <button
                        @click="likePost(post)"
                        :class="[
                            'flex items-center space-x-2',
                            post.liked ? 'text-pink-500' : 'text-gray-400',
                        ]"
                    >
                        <!-- Heart icon -->
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
                        >{{ post.like_count }} likes</span
                    >
                </div>

                <!-- Caption -->
                <div class="text-gray-800 mb-4">
                    <p v-if="post.caption" class="font-semibold">
                        {{ post.user.name }}:
                    </p>
                    <p v-if="post.caption">{{ post.caption }}</p>
                </div>

                <!-- Comments List -->
                <div
                    v-if="post.comments && post.comments.length"
                    class="space-y-2 mb-4"
                >
                    <div
                        v-for="comment in post.comments"
                        :key="comment.id"
                        class="text-sm text-gray-700 flex items-center justify-between"
                    >
                        <div class="flex-1">
                            <span v-if="!comment.editing" class="font-semibold">
                                {{ comment.user }}:
                            </span>
                            <span v-if="!comment.editing">{{
                                comment.comment
                            }}</span>
                            <input
                                v-else
                                v-model="comment.editComment"
                                class="w-full border rounded px-2 py-1 text-sm focus:outline-none focus:ring focus:border-purple-400"
                            />
                        </div>
                        <div class="flex items-center space-x-2 ml-2">
                            <button
                                v-if="!comment.editing"
                                @click="startEditComment(post, comment)"
                                class="text-blue-500 text-xs"
                            >
                                Edit
                            </button>
                            <button
                                v-else
                                @click="updateComment(post, comment)"
                                class="text-green-500 text-xs"
                            >
                                Save
                            </button>
                            <button
                                v-if="comment.editing"
                                @click="cancelEditComment(comment)"
                                class="text-gray-500 text-xs"
                            >
                                Cancel
                            </button>
                            <button
                                @click="deleteComment(post, comment)"
                                class="text-red-500 text-xs"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add Comment Form -->
                <form
                    @submit.prevent="submitComment(post)"
                    class="flex items-center mt-2"
                >
                    <input
                        v-model="post.newComment"
                        type="text"
                        placeholder="Add a comment..."
                        class="flex-1 border rounded-full px-4 py-2 text-sm focus:outline-none focus:ring focus:border-purple-400"
                    />
                    <button
                        type="submit"
                        class="ml-2 text-purple-600 hover:text-purple-800 font-semibold text-sm"
                    >
                        Post
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        posts: Array,
        currentUserId: Number,
    },
    methods: {
        formatDate(date) {
            return new Date(date).toLocaleString();
        },
        async likePost(post) {
            if (post.liking) return; // Cegah spam click

            const originalLiked = post.liked;
            const originalLikesCount = post.like_count;

            // Optimistic UI update
            post.liking = true;
            post.liked = !post.liked;
            post.like_count += post.liked ? 1 : -1;
            post.animating = true;
            setTimeout(() => {
                post.animating = false;
            }, 300);

            try {
                const response = await axios.post(`/posts/${post.id}/like`);
                // Update jumlah likes dari respons server
                post.like_count = response.data.like_count;
                post.liked = response.data.liked;
            } catch (e) {
                console.error("Failed to like/unlike:", e);
                // Rollback kalau error
                post.liked = originalLiked;
                post.like_count = originalLikesCount;
            } finally {
                post.liking = false;
            }
        },
        async submitComment(post) {
            if (!post.newComment || post.newComment.trim() === "") return;

            const commentText = post.newComment;
            post.newComment = "";

            try {
                const response = await axios.post(
                    `/posts/${post.id}/comments`,
                    {
                        comment: commentText,
                    }
                );

                if (!post.comments) {
                    post.comments = [];
                }
                post.comments.push({
                    id: response.data.id,
                    user: response.data.user,
                    comment: response.data.comment,
                    created_at: response.data.created_at,
                });
            } catch (error) {
                console.error("Failed to submit comment:", error);
            }
        },
        startEditComment(post, comment) {
            comment.editing = true;
            comment.editComment = comment.comment; // Simpan nilai asli
        },
        async updateComment(post, comment) {
            try {
                const response = await axios.put(`/comments/${comment.id}`, {
                    comment: comment.editComment,
                });
                comment.comment = response.data.comment; // Perbarui komentar
                comment.editing = false; // Keluar dari mode edit
            } catch (e) {
                console.error("Failed to update comment:", e);
            }
        },
        cancelEditComment(comment) {
            comment.editing = false; // Keluar dari mode edit
            comment.editComment = ""; // Reset nilai edit
        },
        async deleteComment(post, comment) {
            if (!confirm("Are you sure you want to delete this comment?"))
                return;

            try {
                await axios.delete(`/comments/${comment.id}`);
                post.comments = post.comments.filter(
                    (c) => c.id !== comment.id
                );
            } catch (e) {
                console.error("Failed to delete comment:", e);
            }
        },
    },
};
</script>
