<template>
    <div>
    <form @submit.prevent="submit">
        <div class="card-body">
            <textarea class="form-control border-0 bg-light"
                      name="body"
                      placeholder="what you think Faustino?"
                      v-model="body"></textarea>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" id="create-status">Publish</button>
        </div>
    </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: '',
            }
        },
        methods: {
            submit() {
                axios.post('/statuses', {body: this.body})
                    .then(res => {
                        EventBus.$emit('status-created',res.data)
                        this.body=''

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })
            }
        }
    }
</script>
