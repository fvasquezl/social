<template>
        <button v-if="status.is_liked"
                @click="unlike(status)"
                class="btn btn-link btn-sm"
                dusk="unlike-btn"
        ><strong>
            <i class="far fa-thumbs-up mr-1"></i>
            YOU LIKE</strong></button>
        <button v-else
                @click="like(status)"
                class="btn btn-link btn-sm"
                dusk="like-btn"
        ><i class="far fa-thumbs-up text-primary mr-1"></i>
            I LIKE
        </button>
</template>

<script>
    export default {

    }
</script>

<style scoped>

</style>
