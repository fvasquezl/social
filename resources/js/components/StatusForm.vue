<template>
    <div>
    <form @submit.prevent="submit" v-if="isAuthenticated">
        <div class="card-body">
            <textarea class="form-control border-0 bg-light"
                      name="body"
                      :placeholder="`what you think ${currentUser.name}?`"
                      v-model="body"></textarea>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" id="create-status">Publish</button>
        </div>
    </form>
        <div v-else class="card-body">
            <a href="/login">Go to login</a>
        </div>
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
                        EventBus.$emit('status-created',res.data.data)
                        this.body=''

                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })
            }
        }
    }
</script>
