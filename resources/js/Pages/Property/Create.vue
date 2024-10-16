<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted, ref} from "vue";
import Toast from '@/Components/Toast.vue';

const toastMessage = ref('');
const isToastVisible = ref(false);

const regions = ref([]);
const provinces = ref([]);
const cities = ref([]);
const barangays = ref([]);
const selectedRegion = ref('');

const fetchRegions = async () => {
    const response = await fetch('https://psgc.cloud/api/regions'); // Example API
    regions.value = await response.json();
};

const fetchProvinces = async () => {
    if (!selectedRegion.value) return;

    const provinceResponse = await fetch(`https://psgc.cloud/api/regions/${selectedRegion.value}/provinces`);
    provinces.value = await provinceResponse.json();

    const cityResponse = await fetch(`https://psgc.cloud/api/regions/${selectedRegion.value}/cities`);
    cities.value = await cityResponse.json();

    const barangayResponse = await fetch(`https://psgc.cloud/api/regions/${selectedRegion.value}/barangays`);
    barangays.value = await barangayResponse.json();
};

onMounted(fetchRegions);

const form = useForm({
    inertia: true,
    name: '',
    description: '',
    price: null,
    size: null,
    bedrooms: null,
    bathrooms: null,
    property_type: '',
    status: '',
    condition: '',
    date_built: '',
    parking_spaces: null,
    utilities_included: '',
    lease_terms: '',
    location: {
        block_number: '',
        lot_number: '',
        street: '',
        village: '',
        city: '',
        region: '',
    }
});

const handleSubmit = () => {
    form.post(route('property.store'), {
        onSuccess: () => {
            toastMessage.value =
                'You property was listed successfully!';
            isToastVisible.value = true;
        },
        onError: (error) => {
            console.log(error);
            toastMessage.value =
                'An error occurred while trying to process your property';
            isToastVisible.value = true;
        }
    });
};

</script>

<template>
    <AppLayout title="Add Property">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Property
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div class="container mx-auto">
                        <form @submit.prevent="handleSubmit" class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">
                            <h2 class="text-xl font-semibold mb-4">Property Listing Form</h2>

                            <div class="mb-4">
                                <InputLabel
                                    for="block_number"
                                    value="Enter Block Number"
                                />
                                <TextInput
                                    id="block_number"
                                    v-model="form.location.block_number"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="location.block_number"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.location"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="lot_number"
                                    value="Enter Lot Number"
                                />
                                <TextInput
                                    id="lot_number"
                                    v-model="form.location.lot_number"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="location.lot_number"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.location"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="street"
                                    value="Enter Street"
                                />
                                <TextInput
                                    id="street"
                                    v-model="form.location.street"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="location.street"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.location"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="name"
                                    value="Select Region"
                                />
                                <select id="region" v-model="selectedRegion" @change="fetchProvinces" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-500">
                                    <option value="">Select Region</option>
                                    <option v-for="region in regions" :key="region.code" :value="region.code">{{ region.name }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="region" class="block text-sm font-medium text-gray-700">Provinces</label>
                                <select id="region" v-model="form.location.region" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-500">
                                    <option value="">Select Province</option>
                                    <option v-for="province in provinces" :key="province.code" :value="province.code">{{ province.name }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="region" class="block text-sm font-medium text-gray-700">Cities/Municipalities</label>
                                <select id="region" v-model="form.location.city" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-500">
                                    <option value="">Select City/Municipality</option>
                                    <option v-for="city in cities" :key="city.code" :value="city.code">{{ city.name }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="region" class="block text-sm font-medium text-gray-700">Barangays/Villages</label>
                                <select id="region" v-model="form.location.village" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-500">
                                    <option value="">Select Barangay/Village</option>
                                    <option v-for="barangay in barangays" :key="barangay.code" :value="barangay.code">{{ barangay.name }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="name"
                                    value="Enter Name"
                                />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="name"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="description"
                                    value="Description"
                                />
                                <TextInput
                                    id="description"
                                    v-model="form.description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="description"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.description"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="price"
                                    value="price"
                                />
                                <TextInput
                                    id="size"
                                    v-model="form.price"
                                    type="number"
                                    class="mt-1 block w-full"
                                    autocomplete="price"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.price"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="size"
                                    value="Size"
                                />
                                <TextInput
                                    id="size"
                                    v-model="form.size"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="size"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.size"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="bedrooms"
                                    value="Bedrooms"
                                />
                                <TextInput
                                    id="bedrooms"
                                    v-model="form.bedrooms"
                                    type="number"
                                    class="mt-1 block w-full"
                                    autocomplete="bedrooms"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.bedrooms"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="bathrooms"
                                    value="Bathrooms"
                                />
                                <TextInput
                                    id="bathrooms"
                                    v-model="form.bathrooms"
                                    type="number"
                                    class="mt-1 block w-full"
                                    autocomplete="bathrooms"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.bathrooms"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="property_type"
                                    value="Property Type"
                                />
                                <select id="property_type" v-model="form.property_type" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option value="1">House</option>
                                    <option value="2">Apartment</option>
                                    <option value="3">Commercial Space</option>
                                    <option value="4">Land</option>
                                    <option value="5">Condo</option>
                                    <option value="6">Villa</option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.property_type"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="status"
                                    value="Status"
                                />
                                <select id="status" v-model="form.status" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option value="1">Available</option>
                                    <option value="2">Rented</option>
                                    <option value="3">Sold</option>
                                    <option value="4">Under Maintenance</option>
                                    <option value="5">Reserved</option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.status"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="condition"
                                    value="Condition"
                                />
                                <select id="condition" v-model="form.condition" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option value="1">New</option>
                                    <option value="2">Good</option>
                                    <option value="3">Needs Repair</option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.condition"
                                />
                            </div>

                            <div class="mb-4">
                                <label for="cover-photo" class="block text-sm font-medium text-gray-700">Cover Photo</label>
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Upload a file</span>
                                                <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 5MB</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="date_built"
                                    value="Date Built"
                                />
                                <TextInput
                                    id="bathrooms"
                                    v-model="form.date_built"
                                    type="date"
                                    class="mt-1 block w-full"
                                    autocomplete="date_built"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.date_built"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="parking_spaces"
                                    value="Parking Spaces"
                                />
                                <TextInput
                                    id="parking_spaces"
                                    v-model="form.parking_spaces"
                                    type="number"
                                    class="mt-1 block w-full"
                                    autocomplete="parking_spaces"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.parking_spaces"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="utilities_included"
                                    value="Utilities Included"
                                />
                                <select id="utilities_included" v-model="form.utilities_included" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.utilities_included"
                                />
                            </div>

                            <div class="mb-4">
                                <InputLabel
                                    for="lease_terms"
                                    value="Lease Terms"
                                />
                                <select id="lease_terms" v-model="form.lease_terms" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option v-for="i in 12" :key="i" :value="i * 3">{{ i * 3 }}</option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.lease_terms"
                                />
                            </div>

                            <p>add location</p>
                            <p>add property features</p>
                            <p>add amenities</p>


                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    class="ms-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Register
                                </PrimaryButton>
                            </div>

                        </form>
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
