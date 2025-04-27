<template>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center space-x-4 mb-4">
            <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
            <div>
                <p class="font-semibold">John Doe</p>
                <p class="text-sm text-gray-500">Example photograph</p>
            </div>
        </div>
        <img
            src="https://via.placeholder.com/400x300"
            alt="Post Image"
            class="w-full rounded mb-4"
        />
        <div class="flex items-center space-x-2 mb-2">
            <button class="text-gray-500 hover:text-pink-500">
                <!-- Like Icon -->
            </button>
            <span class="text-gray-600">1 like</span>
        </div>
        <div>
            <p class="text-gray-800">
                <span class="font-semibold">Someone:</span> Looks great!
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: "PostCard",
};
</script>
