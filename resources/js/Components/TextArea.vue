<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    rows: {
        default: 4
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
        <textarea
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :rows="rows" name="comment" id="comment" class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6"></textarea>
</template>
