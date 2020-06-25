<template>
    <div v-if="localFriendshipStatus==='pending'">
        You have a friend request from <span v-text="sender.name"></span>
        <button dusk="accept-friendship" @click="acceptFriendshipRequest">
            Accepted Request
        </button>
        <button dusk="deny-friendship" @click="denyFriendshipRequest">
            Denied request
        </button>
    </div>
    <div v-else-if="localFriendshipStatus==='accepted'">
         <span v-text="sender.name"></span> and you are friends
    </div>
    <div v-else-if="localFriendshipStatus==='denied'">
        Denied request of <span v-text="sender.name"></span>
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
                        this.localFriendshipStatus = res.data.friendship_status
                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })
            },
            denyFriendshipRequest(){
                axios.delete(`/accept-friendships/${this.sender.name}`)
                    .then(res => {
                        this.localFriendshipStatus = res.data.friendship_status
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
