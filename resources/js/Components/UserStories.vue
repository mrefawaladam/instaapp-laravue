<template>
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
</template>
