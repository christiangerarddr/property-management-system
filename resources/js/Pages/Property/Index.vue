<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PropertyCard from '@/Components/PropertyCard.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import { ref, watch } from 'vue';
import {
    fetchProperties,
    fetchFilteredProperties,
} from '@/services/propertyService.js';
import Toast from '@/Components/Toast.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    properties: {
        type: Object,
        required: true,
    },
    notification: {
        type: Object,
        default: () => ({ visible: false, message: '' }),
    }
});

const properties = ref(props.properties);
const filterQuery = ref('');
const toastMessage = ref(props.notification['message']);
const isToastVisible = ref(props.notification['visible']);
let timeout = null;

const loadProperties = async (page) => {
    try {
        properties.value = await fetchProperties(page);
    } catch (error) {
        toastMessage.value =
            'An error occurred when trying to fetch your properties';
        isToastVisible.value = true;
    }
};

const loadFilteredProperties = async () => {
    if (!filterQuery.value) {
        await loadProperties();
        return;
    }

    try {
        properties.value = await fetchFilteredProperties(filterQuery.value);
    } catch (error) {
        toastMessage.value =
            'An error occurred when trying to filter your properties';
        isToastVisible.value = true;
    }
};

watch(filterQuery, (newQuery, oldQuery) => {
    if (newQuery !== oldQuery) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            loadFilteredProperties();
        }, 200);
    }
});
</script>

<template>
    <AppLayout title="Property">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Property
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div class="container mx-auto">
                        <div class="mb-4">
                            <div class="mb-6 flex align-middle justify-between">
                            filter box
                            <Link
                                :href="route('property.create')"
                                class="rounded-md px-3 py-2 text-gray-900 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none"
                            >
                                <PrimaryButton>
                                    Add Property
                                </PrimaryButton>
                            </Link>
                            </div>
                            <input
                                type="text"
                                v-model="filterQuery"
                                placeholder="Search properties..."
                                class="border border-gray-300 rounded-md p-2 w-full"
                            />
                        </div>

                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                        >
                            <template v-for="property in properties.data">
                                <PropertyCard :property="property" />
                            </template>
                        </div>
                        <div class="flex justify-center mt-4">
                            <TailwindPagination
                                :data="properties"
                                @pagination-change-page="loadProperties"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Toast
            :message="toastMessage"
            :isVisible="isToastVisible"
            @close="isToastVisible = false"
        />
    </AppLayout>
</template>
