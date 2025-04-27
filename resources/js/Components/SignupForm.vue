<template>
    <div class="mt-6 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Sign up</h2>
        <form class="space-y-4">
            <input
                type="text"
                placeholder="Mobile Number or Email"
                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <input
                type="text"
                placeholder="Full Name"
                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <button
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600"
            >
                Sign up
            </button>
        </form>
    </div>
</template>

<script>
export default {
    name: "SignupForm",
};
</script>
