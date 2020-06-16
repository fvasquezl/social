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
        props: {
            status: {
                type: Object,
                required: true
            }
        },
        methods: {
            like(status) {
                axios.post(`/statuses/${status.id}/likes`)
                    .then(res => {
                        status.is_liked = true;
                        status.likes_count++;
                    })
                    .catch(err => {

                    })
            },
            unlike(status) {
                axios.delete(`/statuses/${status.id}/likes`)
                    .then(res => {
                        status.is_liked = false;
                        status.likes_count--;
                    })
                    .catch(err => {

                    })
            },
        }
    }
</script>

<style scoped>

</style>
