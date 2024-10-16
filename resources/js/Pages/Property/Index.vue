<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PropertyCard from '@/Components/PropertyCard.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import { ref, watch } from 'vue';
import {
    fetchProperties,
    fetchFilteredProperties,
} from '@/services/propertyService.js';

const props = defineProps({
    properties: {
        type: Object,
    },
});

const properties = ref(props.properties);
const filterQuery = ref('');
let timeout = null;

const loadProperties = async (page) => {
    properties.value = await fetchProperties(page);
};

const loadFilteredProperties = async () => {
    if (!filterQuery.value) {
        await loadProperties();
        return;
    }

    properties.value = await fetchFilteredProperties(filterQuery.value);
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
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div class="container mx-auto">
                        <div class="mb-4">
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
    </AppLayout>
</template>
