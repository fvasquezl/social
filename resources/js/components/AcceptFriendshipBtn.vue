<template>
    <div v-if="localFriendshipStatus==='pending'">
        You have a friend request from <span v-text="sender.name"></span>
        <button dusk="accept-friendship" @click="acceptFriendshipRequest">
            Accepted Request
        </button>
    </div>
    <div v-else>
         <span v-text="sender.name"></span> and you are friends
    </div>

</template>

<script>
    export default {
        props: {
            sender: {
                type: Object,
                required: true
            },
            friendshipStatus: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                localFriendshipStatus: this.friendshipStatus
            }
        },
        methods: {
            acceptFriendshipRequest() {
                axios.post(`/accept-friendships/${this.sender.name}`)
                    .then(res => {
                        this.localFriendshipStatus = 'accepted'
                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
