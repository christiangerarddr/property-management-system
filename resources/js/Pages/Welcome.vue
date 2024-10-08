<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PricingCard from '@/Components/PricingCard.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div
        id="welcome-container"
        class="flex flex-col items-center justify-between"
    >
        <div class="w-full flex flex-col flex-grow">
            <div class="max-w-2xl px-6 lg:max-w-7xl mx-auto">
                <header class="welcome-header items-end py-6">
                    <nav v-if="canLogin" class="flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-gray-900 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-gray-900 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-gray-900 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main
                    class="welcome-main mt-32 flex-grow flex flex-col justify-between"
                >
                    <!-- Hero Banner -->
                    <div class="hero-banner p-6 flex-grow flex flex-col">
                        <h1
                            class="text-gray-900 text-5xl font-bold tracking-tight"
                        >
                            Property Management System
                        </h1>
                        <p class="mt-6 text-gray-600 text-base leading-7">
                            Our Property Management System (PMS) is a
                            user-friendly web application designed to help
                            property owners and real estate brokers effortlessly
                            manage their properties. It streamlines everyday
                            tasks like tenant management, lease tracking,
                            maintenance requests, automatic rent billing, and
                            financial reporting. With convenient features such
                            as online rent collection and intuitive
                            communication tools, our app makes organization a
                            breeze and significantly enhances the overall
                            experience for tenants.
                        </p>
                        <div
                            class="mt-6 grid grid-cols-1 gap-x-8 gap-y-6 text-base font-semibold leading-7 text-gray-900 sm:grid-cols-2 md:flex lg:gap-x-10"
                        >
                            <Link :href="'#'">
                                Tenant Management
                                <span aria-hidden="true">&rarr;</span>
                            </Link>
                            <Link :href="'#'">
                                Lease Tracking
                                <span aria-hidden="true">&rarr;</span>
                            </Link>
                            <Link :href="'#'">
                                Online Rent Collection
                                <span aria-hidden="true">&rarr;</span>
                            </Link>
                            <Link :href="'#'">
                                Learn More
                                <span aria-hidden="true">&rarr;</span>
                            </Link>
                        </div>
                    </div>
                </main>
            </div>

            <!-- Space Between Hero and PricingCard -->
            <div class="welcome-pricing bg-gray-100">
                <PricingCard />
            </div>

            <footer class="py-16 text-center text-sm text-black">
                Property Management App
            </footer>
        </div>
    </div>
</template>
