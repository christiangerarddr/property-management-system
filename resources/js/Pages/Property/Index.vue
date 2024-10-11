<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PropertyCard from '@/Components/PropertyCard.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import {ref} from "vue";

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
