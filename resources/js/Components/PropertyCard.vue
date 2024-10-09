<script setup>
import { computed } from 'vue';
import PropertyTypeHelper from "@/Helpers/PropertyTypeHelper.js";
import PriceFormatHelper from "@/Helpers/PriceFormatHelper.js";

const props = defineProps({
    property: {
        type: Object,
        required: true
    },
});

const propertyType = computed(() => {
    return PropertyTypeHelper.getTypeById(props.property.property_type);
});

const propertyPrice = computed(() => {
    return PriceFormatHelper.formatPrice(props.property.price, 'PHP');
})

</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-lg h-full">
        <div>
            <h2 class="text-xl font-bold mb-4">{{ $props.property.name }}</h2>
            <p class="text-gray-700">{{ $props.property.description }}</p>
        </div>
        <div class="mt-6">
            <p class="text-gray-400 text-sm font-light mt-auto">Type: {{ propertyType }}</p>
            <p class="text-gray-400 text-sm font-light mt-auto">Price: {{ propertyPrice }}</p>
            <p class="text-gray-400 text-sm font-light mt-auto">Size: {{ $props.property.size }} sqm</p>
            <p class="text-gray-400 text-sm font-light mt-auto">Bathroom: {{ $props.property.bathrooms }}</p>
        </div>
    </div>
</template>
