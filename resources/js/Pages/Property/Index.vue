<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PropertyCard from "@/Components/PropertyCard.vue";

defineProps({
    properties: {
        type: Array,
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                    <div class="container mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <template v-for="property in $props.properties.data">
                                <PropertyCard :property="property" />
                            </template>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
