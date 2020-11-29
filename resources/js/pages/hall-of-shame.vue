<template>
    <div class="container flex flex-col items-center justify-between min-h-screen py-8">
        <div></div>

        <div>
            <div class="mb-8 text-center">
                <h1 class="mb-2 text-4xl">
                    Hall of Shame
                </h1>
                <p>You have voted !</p>
            </div>

            <div class="flex flex-wrap justify-center mb-8 -mx-4 -mt-2">
                <inertia-link
                    :href="$route('show', representation.emoji.slug)"
                    v-for="representation in representations"
                    v-bind:key="representation.id"
                    class="flex flex-col items-center h-64 py-6 m-2 transition transform bg-white rounded-lg shadow-lg cursor-pointer w-36 hover:-translate-y-1 hover:scale-110 hover:shadow-xl focus:outline-none"
                >
                    <img :src="representation.src" :alt="representation.alt" class="px-8 mb-auto">
                    <div class="px-4 mb-4 text-center">
                        {{ representation.emoji.name }}
                        <div class="text-sm">
                            as seen by
                        </div>
                        {{ representation.vendor.name }}
                    </div>
                    <div
                        class="px-4 text-xs font-semibold uppercase"
                        :class="{ 'text-gray-300': representation.down_votes_count == 0, 'text-gray-400': representation.down_votes_count }"
                    >{{ representation.down_votes_count }} vote(s)</div>
                </inertia-link>
            </div>
        </div>

        <div class="text-sm text-center text-gray-400">
            <inertia-link :href="$route('home')" class="underline hover:no-underline">Home</inertia-link><br>
            Base emoji data fetched from <a href="https://emojipedia.org/" target="_blank" class="underline hover:no-underline">Emojipedia</a><br>
            Handcrafted by <a href="https://mgk.dev/" target="_blank" class="underline hover:no-underline">MGK</a> - <a href="https://github.com/mgkprod/emojibattle" target="_blank" class="underline hover:no-underline">GitHub</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['representations'],

        methods: {
        }
    }
</script>
