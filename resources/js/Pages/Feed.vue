<template>
    <div class="max-w-4xl mx-auto pt-4 px-4 relative">
        <TopBar />
        <UserStories />
        <CreatePostButton />

        <div class="space-y-6">
            <PostCard v-for="post in posts" :key="post.id" :post="post" />
        </div>
    </div>
</template>

<script>
import TopBar from "../Components/TopBar.vue";
import UserStories from "../Components/UserStories.vue";
import CreatePostButton from "../Components/CreatePostButton.vue";
import PostCard from "../Components/PostCard.vue";

export default {
    props: {
        posts: Array,
    },
    components: {
        TopBar,
        UserStories,
        CreatePostButton,
        PostCard,
    },
};
</script>
