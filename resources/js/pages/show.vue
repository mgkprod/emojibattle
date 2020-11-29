<template>
    <div class="container flex flex-col items-center justify-between min-h-screen py-8">
        <div></div>

        <div>
            <div class="mb-8 text-center">
                <h1 class="mb-2 text-4xl">
                    {{ emoji.name }}
                </h1>
                <p>Vote for the worst !</p>
            </div>

            <div class="flex flex-wrap justify-center mb-8 -mx-4 -mt-2">
                <button
                    @click="submit(representation.id)"
                    v-for="representation in emoji.representations"
                    v-bind:key="representation.id"
                    class="flex flex-col items-center h-48 py-6 m-2 transition transform bg-white rounded-lg shadow-lg cursor-pointer w-36 hover:-translate-y-1 hover:scale-110 hover:shadow-xl focus:outline-none"
                >
                    <img :src="representation.src" :alt="representation.alt" class="px-8 mb-auto">
                    <div class="px-4">{{ representation.vendor.name }}</div>
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase">{{ representation.down_votes_count }} vote(s)</div>
                </button>
            </div>

            <div class="text-center">
                <inertia-link :href="$route('home')" class="inline-block px-4 py-2 mx-auto text-sm font-bold text-white bg-blue-500 rounded-lg shadow-lg">or skip to the next emoji !</inertia-link>
            </div>
        </div>

        <div class="text-sm text-center text-gray-400">
            Base emoji data fetched from <a href="https://emojipedia.org/" target="_blank" class="underline hover:no-underline">Emojipedia</a><br>
            Handcrafted by <a href="https://mgk.dev/" target="_blank" class="underline hover:no-underline">MGK</a> - <a href="https://github.com/mgkprod/emojibattle" target="_blank" class="underline hover:no-underline">GitHub</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['emoji'],

        methods: {
            submit(representation_id){
                this.$inertia.post(
                    this.$route('home'), { representation_id }
                )
            }
        }
    }
</script>
