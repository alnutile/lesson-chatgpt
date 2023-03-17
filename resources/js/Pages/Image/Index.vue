<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Image Generator
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <SectionTitle class="p-4">
                        <template #title>Image Creation</template>
                        <template #description>
                            Let's make an image
                        </template>
                    </SectionTitle>
                    <div class="grid grid-cols-12 gap-2">
                        <div class="col-span-4 p-4">
                            <form @submit.prevent="submit">
                                <div>
                                    <InputLabel>Ask your question</InputLabel>
                                    <textarea
                                        v-model="form.prompt"
                                        rows="12"
                                        placeholder="A pencil drawing of bob belcher"
                                        name="ask" id="ask"
                                        class="block w-full rounded-md border-0
                                        text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6">
                                    </textarea>
                                </div>

                                <div
                                    v-if="chosenGenres.length > 0"
                                    class="flex justify-center mt-2 flex-wrap gap-2">
                                    <div
                                        @click="removeGenre(genreChosen)"
                                        v-for="genreChosen in form.genres"
                                        class="badge badge-info gap-2 hover:cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        {{ genreChosen }}
                                    </div>
                                </div>

                                <div
                                    v-if="chosenStyle.length > 0"
                                    class="flex justify-center mt-2 flex-wrap gap-2">
                                    <div
                                        @click="removeStyle(styleChosen)"
                                        v-for="styleChosen in form.styles"
                                        class="badge badge-success gap-2 hover:cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        {{ styleChosen }}
                                    </div>
                                </div>

                                <div class="flex justify-end mt-4">
                                    <button
                                        class="disabled:opacity-90 btn btn-primary disabled:text-gray-400"
                                        :disabled="form.processing || form.input === null"
                                        type="submit">Create an Image!
                                    </button>
                                </div>


                            </form>

                        </div>
                        <div class="col-span-7 p-4">
                            <h1 id="primary-heading" class="sr-only">Results will show here</h1>
                            <div>
                                <SectionTitle>
                                    <template #title>The Image will show here</template>
                                    <template #description>
                                        Once you click generate then in about 30 seconds your image will show here.
                                    </template>
                                </SectionTitle>

                                <div v-if="results" v-for="result in results" class="py-2">

                                    <div class=" flex items-center justify-start gap-4">
                                        <img :src="result">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 flex justify-between p-6">
                            <div class="flex flex-col">
                                <label for="day" class="font-bold mb-2">Some Example Prompts to get you thinking</label>
                                <select
                                    id="day"
                                    @change="setPrompt"
                                    v-model="example_prompt"
                                    class="select w-full max-w-xs ring ring-indigo-400">
                                    <option disabled selected>Try one</option>
                                    <option v-for="(promptExample, promptIndex) in example_prompts"
                                            :value="promptExample"
                                            :key="promptExample">
                                        {{ promptExample }}
                                    </option>
                                </select>
                            </div>

                            <div class="flex flex-col px-12">
                                <div>
                                    <h1 class="p-2 font-bold">Choose a genre or two!</h1>
                                    <div class="flex justify-center gap-2 max-w-4xl flex-wrap">
                                        <button
                                            @click="addGenre(genre)"
                                            class="btn-secondary rounded btn-sm" v-for="genre in props.genre">
                                            {{ genre }}
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <h1 class="p-2 font-bold">Choose a style or two!</h1>
                                    <div class="flex justify-center gap-2 max-w-4xl flex-wrap">
                                        <button
                                            @click="addStyle(style)"
                                            class="btn-success rounded btn-sm" v-for="style in props.styles">
                                            {{ style }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextArea from "@/Components/TextArea.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue"
import SectionTitle from "@/Components/SectionTitle.vue"
import {useToast} from "vue-toastification";
import {computed, ref} from "vue";

const toast = useToast();

const results = ref([])

const props = defineProps([
    'example_prompts',
    'styles',
    'genre'
])

const form = useForm({
    genres: new Set(),
    styles: new Set(),
    prompt: null,
    processing: false,
})

let example_prompt = ref("")

const setPrompt = () => {
    form.prompt = example_prompt;
}

const removeGenre = (genre) => {
    form.genres.delete(genre)
}

const addGenre = (genre) => {
    form.genres.add(genre)
}

const chosenGenres = computed(() => {
    return Array.from(form.genres);
})

const removeStyle = (style) => {
    form.styles.delete(style)
}

const addStyle = (style) => {
    form.styles.add(style)
}

const chosenStyle = computed(() => {
    return Array.from(form.styles);
})

const submit = () => {
    console.log('asking')
    toast("Generating Image back in a minute")
    form.processing = true;
    axios.post(route('examples.image.request'), {
        prompt: form.prompt,
        genres: form.genres,
        styles: form.styles,
    }).then(data => {
        console.log(data)
        results.value = data.data;
        form.processing = false;
    }).catch(error => {
        console.log(error.message)
        toast.error("Oops")
        form.processing = false;
    })
}


</script>

<style scoped>

</style>
