<template>
    <div class="flex justify-end mb-4">
        <button
            @click="goToCreatePost"
            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700"
        >
            Create Post
        </button>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

function goToCreatePost() {
    router.visit("/posts/create");
}
</script>
