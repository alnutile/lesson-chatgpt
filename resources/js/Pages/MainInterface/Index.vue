<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Work out ideas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="col-span-4 p-4">
                            <InputLabel>Ask your question</InputLabel>
                            <TextArea v-model="form.input"/>
                        </div>
                        <div class="col-span-7 p-4">
                            <h1 id="primary-heading" class="sr-only">Results will show here</h1>
                            <div>
                                results...
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

const form = useForm({
    input: ""
})
</script>

<style scoped>

</style>
