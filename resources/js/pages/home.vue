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

            <div class="flex flex-wrap justify-center -mx-4 -mt-2">
                <button
                    v-for="representation in emoji.representations"
                    v-bind:key="representation.vendor.name"
                    class="flex flex-col items-center h-48 py-6 m-2 transition transform bg-white rounded-lg shadow-lg cursor-pointer w-36 hover:-translate-y-1 hover:scale-110 hover:shadow-xl focus:outline-none"
                >
                    <img :src="representation.image.src" :alt="representation.image.alt" class="px-8 mb-auto">
                    <div class="px-4">{{ representation.vendor.name }}</div>
                    <div class="px-4 text-xs font-semibold text-gray-400 uppercase">0 vote(s)</div>
                </button>
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
        props: ['emoji']
    }
</script>
