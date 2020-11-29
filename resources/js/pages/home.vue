<template>
    <div>
        <div class="flex flex-col items-center justify-center h-screen">
            <div class="mb-8 text-4xl font-thin text-center text-gray-600">
                <div class="mb-2 text-6xl">{{ emoji.emoji }}</div>
                {{ emoji.name }}
            </div>

            <p>{{ emoji.description }}</p>

            <div class="flex flex-wrap space-x-2 space-y-2">
                <div v-for="representation in emoji.representations" v-bind:key="representation.vendor.name">
                    <div>{{ representation.vendor.name }}</div>
                    <img :src="representation.image.src" :alt="representation.image.alt" class="w-48">
                    <!-- <a class="px-6 text-sm font-semibold tracking-widest text-gray-600 uppercase" href="https://laravel.com/docs"></a> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['emoji']
    }
</script>
