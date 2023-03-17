<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ask question
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-4 p-4">
                                <form @submit.prevent="submit">

                                <InputLabel>Ask your question</InputLabel>
                                    <textarea
                                        v-model="form.input"
                                        rows="12"
                                        placeholder="Ask your question here"
                                        name="ask" id="ask"
                                        class="block w-full rounded-md border-0
                                        text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6">
                                    </textarea>
                                <div class="flex justify-end mt-2">
                                    <button
                                        class="disabled:opacity-90 btn btn-primary disabled:text-gray-400"
                                        :disabled="form.processing || form.input === null"
                                        type="submit">Ask</button>
                                </div>
                                </form>

                            </div>
                        <div class="col-span-7 p-4">
                            <h1 id="primary-heading" class="sr-only">Results will show here</h1>
                            <div>
                                <SectionTitle>
                                    <template #title>The results will show here</template>
                                    <template #description>
                                        This is a simple example of if we just ask ChatGPT api davinci questions.
                                    </template>
                                </SectionTitle>

                                <div v-html="results">

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
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue"
import SectionTitle from "@/Components/SectionTitle.vue"
import {useToast} from "vue-toastification";
import {ref} from "vue";

const toast = useToast();

const results = ref(null)

const form = useForm({
    input: null
})

const submit = () => {
    console.log('asking')
    toast("Asking question back in a moment")
    form.processing = true;
    axios.post(route('examples.ask'), {
        input: form.input
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
