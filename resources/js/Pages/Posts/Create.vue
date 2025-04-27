<template>
    <div class="max-w-md mx-auto py-10">
        <button
            @click="$inertia.visit('/feed')"
            class="mb-4 text-purple-600 hover:text-purple-800"
        >
            ← Back
        </button>
        <h1 class="text-2xl font-bold mb-6 text-center">Create New Post</h1>
        <form
            @submit.prevent="createPost"
            class="bg-white shadow-md rounded-lg p-6 space-y-4"
        >
            <div>
                <label class="block mb-2 text-sm font-medium"
                    >Upload Image</label
                >
                <input
                    type="file"
                    @change="handleImageUpload"
                    accept="image/*"
                    class="w-full border rounded p-2"
                />
                <div v-if="preview" class="mt-4">
                    <img :src="preview" class="w-full rounded" />
                </div>
                <p v-if="errors.image" class="text-red-500 text-sm mt-1">
                    {{ errors.image }}
                </p>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium">Caption</label>
                <textarea
                    v-model="form.caption"
                    rows="3"
                    class="w-full border rounded p-2"
                    placeholder="Write a caption..."
                ></textarea>
                <p v-if="errors.caption" class="text-red-500 text-sm mt-1">
                    {{ errors.caption }}
                </p>
            </div>

            <button
                type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg"
                :disabled="form.processing"
            >
                {{ form.processing ? "Posting..." : "Post" }}
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                image: null,
                caption: "",
            },
            preview: null,
            successMessage: "",
        };
    },
    computed: {
        errors() {
            return this.$page.props.errors || {};
        },
    },
    methods: {
        handleImageUpload(e) {
            const file = e.target.files[0];
            this.form.image = file;
            if (file) {
                this.preview = URL.createObjectURL(file);
            }
        },
        async createPost() {
            try {
                await this.$inertia.post(
                    "/posts", // endpoint yang sesuai untuk membuat post
                    {
                        image: this.form.image,
                        caption: this.form.caption,
                    },
                    {
                        onSuccess: () => {
                            this.successMessage = "Post created successfully!";
                            this.form.caption = "";
                            this.form.image = null;
                            this.preview = null;
                        },
                        onError: () => {
                            this.successMessage = "";
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
