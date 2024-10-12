<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PropertyCard from '@/Components/PropertyCard.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import {ref, watch} from "vue";

const props = defineProps({
    properties: {
        type: Object,
    },
});

const properties = ref(props.properties);

const getResults = async (page = 1) => {
    const response = await fetch(`http://property-management-system.test/properties?page=${page}`);
    properties.value = await response.json();
}

const filterQuery = ref('');

const fetchFilteredProperties = async () => {

    if (!filterQuery.value) {
        await getResults();
        return;
    }

    const response = await fetch(`http://property-management-system.test/property/filter`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.laravel.csrfToken
        },
        body: JSON.stringify({
            filters: {
                name: filterQuery.value
            }
        })
    });
    properties.value = await response.json();
}

let timeout = null;

watch(filterQuery, (newQuery, oldQuery) => {
    if (newQuery !== oldQuery) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            fetchFilteredProperties();
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
                            <template
                                v-for="property in properties.data"
                            >
                                <PropertyCard :property="property" />
                            </template>
                        </div>
                        <div class="flex justify-center mt-4">
                            <TailwindPagination
                                :data="properties"
                                @pagination-change-page="getResults"
                            />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
