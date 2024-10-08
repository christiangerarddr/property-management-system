<script setup>
import { CheckIcon } from '@heroicons/vue/20/solid'

const tiers = [
    {
        name: 'Hobby',
        id: 'tier-hobby',
        href: '#',
        priceMonthly: '$29',
        description: "The perfect plan if you're just getting started with our product.",
        features: ['25 products', 'Up to 10,000 subscribers', 'Advanced analytics', '24-hour support response time'],
        featured: false,
    },
    {
        name: 'Enterprise',
        id: 'tier-enterprise',
        href: '#',
        priceMonthly: '$99',
        description: 'Dedicated support and infrastructure for your company.',
        features: [
            'Unlimited products',
            'Unlimited subscribers',
            'Advanced analytics',
            'Dedicated support representative',
            'Marketing automations',
            'Custom integrations',
        ],
        featured: true,
    },
]
</script>

<template>
    <div class="mx-auto my-16 grid max-w-lg grid-cols-1 items-center gap-y-6 sm:mt-20 sm:gap-y-0 lg:max-w-4xl lg:grid-cols-2">
        <div v-for="(tier, tierIdx) in tiers" :key="tier.id" :class="[tier.featured ? 'relative bg-gray-900 shadow-2xl' : 'bg-white/60 sm:mx-8 lg:mx-0', tier.featured ? '' : tierIdx === 0 ? 'sm:rounded-b-none lg:rounded-tr-none' : 'sm:rounded-t-none lg:rounded-bl-none', 'p-8 ring-1 ring-gray-900/10 sm:p-10']">
            <h3 :id="tier.id" :class="[tier.featured ? 'text-gray-400' : 'text-gray-600', 'text-base font-semibold leading-7']">{{ tier.name }}</h3>
            <p class="mt-4 flex items-baseline gap-x-2">
                <span :class="[tier.featured ? 'text-white' : 'text-gray-900', 'text-5xl font-bold tracking-tight']">{{ tier.priceMonthly }}</span>
                <span :class="[tier.featured ? 'text-gray-400' : 'text-gray-500', 'text-base']">/month</span>
            </p>
            <p :class="[tier.featured ? 'text-gray-300' : 'text-gray-600', 'mt-6 text-base leading-7']">{{ tier.description }}</p>
            <ul role="list" :class="[tier.featured ? 'text-gray-300' : 'text-gray-600', 'mt-8 space-y-3 text-sm leading-6 sm:mt-10']">
                <li v-for="feature in tier.features" :key="feature" class="flex gap-x-3">
                    <CheckIcon :class="[tier.featured ? 'text-gray-400' : 'text-gray-600', 'h-6 w-5 flex-none']" aria-hidden="true" />
                    {{ feature }}
                </li>
            </ul>
            <a :href="tier.href" :aria-describedby="tier.id" :class="[tier.featured ? 'bg-gray-500 text-white shadow-sm hover:bg-gray-400 focus-visible:outline-gray-500' : 'text-gray-600 ring-1 ring-inset ring-gray-200 hover:ring-gray-300 focus-visible:outline-gray-600', 'mt-8 block rounded-md px-3.5 py-2.5 text-center text-sm font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 sm:mt-10']">Get started today</a>
        </div>
    </div>
</template>
