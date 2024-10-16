<script setup>
import {defineEmits } from "vue";

const props = defineProps({
    message: {
        type: String,
        required: true,
    },
    isVisible: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits();

const closeToast = () => {
    emit('close');
};
</script>

<template>
    <div
        v-if="isVisible"
        id="toast-general"
        class="flex items-center w-full max-w-xs p-4 mb-4 bg-white rounded-lg shadow"
        role="alert"
    >
        <div class="ml-3 text-sm">{{ message }}</div>
        <button
            aria-label="Close"
            class="ml-auto text-gray-400 hover:text-gray-900 rounded-lg p-1.5"
            data-dismiss-target="#toast-success"
            type="button"
            @click="closeToast"
        >
            <span class="sr-only">Close</span>
            <svg
                aria-hidden="true"
                class="w-3 h-3"
                fill="none"
                viewBox="0 0 14 14"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                />
            </svg>
        </button>
    </div>
</template>

<style scoped>
    #toast-general {
        position: absolute;
        top: 35px;
        right: 35px;
    }
</style>
