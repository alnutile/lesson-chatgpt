<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bob's Barber Shop
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <SectionTitle class="p-4">
                        <template #title>Welcome</template>
                        <template #description>
                            Choose a day and time range you would like a haircut (approx 30minutes)
                        </template>
                    </SectionTitle>
                    <div class="grid grid-cols-12 gap-2">

                            <div class="col-span-4 p-4">
                                <form @submit.prevent="submit">


                                <div>
                                    <label for="day" class="font-bold">Choose your Day</label>
                                    <select
                                        id="day"
                                        v-model="form.day"
                                        class="select w-full max-w-xs ring ring-indigo-400">
                                        <option disabled selected>Day</option>
                                        <option v-for="(day, dayIndex) in days"
                                                :value="day"
                                                :key="day">
                                            {{ day }}
                                        </option>
                                    </select>
                                </div>


                                <div class="mt-2">
                                    <label for="start_time" class="font-bold">Choose Start Time</label>
                                    <select
                                        id="start_time"
                                        v-model="form.start"
                                        class="select w-full max-w-xs ring ring-indigo-400">
                                        <option disabled selected>Start Time</option>
                                        <option v-for="(start, startIndex) in start_time"
                                                :value="start"
                                                :key="start">
                                            {{ start }}
                                        </option>
                                    </select>
                                </div>

                                <div class="mt-2">
                                    <label for="end_time" class="font-bold">Choose End Time</label>
                                    <select
                                        :disabled="form.start === null"
                                        id="end_time"
                                        v-model="form.end"
                                        class="select w-full max-w-xs ring ring-indigo-400">
                                        <option disabled selected>End Time</option>
                                        <option v-for="(end, endIndex) in endTimes"
                                                :value="end"
                                                :key="end">
                                            {{ end }}
                                        </option>
                                    </select>
                                </div>


                                <div class="flex justify-end mt-4">
                                    <button
                                        class="disabled:opacity-90 btn btn-primary disabled:text-gray-400"
                                        :disabled="form.processing || form.input === null"
                                        type="submit">Look for times!</button>
                                </div>
                                </form>

                            </div>
                        <div class="col-span-7 p-4">
                            <h1 id="primary-heading" class="sr-only">Results will show here</h1>
                            <div>
                                <SectionTitle>
                                    <template #title>Choose your times</template>
                                    <template #description>
                                        You will see some available slots here shortly.
                                    </template>
                                </SectionTitle>

                                <div v-if="results" v-for="result in results" class="py-2">

                                    <div class=" flex items-center justify-start gap-4">{{ result }} <button class="btn btn-sm btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button></div>
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
import {computed, ref} from "vue";

const toast = useToast();

const results = ref(null)

const props = defineProps([
    'days',
    'start_time',
    'end_time'
])

const form = useForm({
    start: null,
    end: null,
    day: null
})

const submit = () => {
    console.log('asking')
    toast("Looking for appointment slots")
    form.processing = true;
    axios.post(route('examples.barber.request'), {
        start: form.start,
        end: form.end,
        day: form.day,
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

const endTimes = computed(() => {
    if(form.start === null) {
        return props.end_time;
    }

    let startTimeKey = null;

    collect(props.start_time).map((value, key) => {
        if(value === form.start) {
            startTimeKey = key;
        }
    })

    return collect(props.end_time).filter((value, key) => {
        return key > startTimeKey
    }).all();
})

</script>

<style scoped>

</style>
