<template>
    <div class="card border-0 mb-3 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class=" d-flex align-items-center mb-3">
                <img class="rounded mr-3 shadow-sm" width="40px"
                     :src="status.user.avatar" alt="status.user.name">
                <div>
                    <h5 class="mb-1"><a :href="status.user.link" v-text="status.user.name"></a></h5>
                    <div class="small text-muted" v-text="status.ago"></div>
                </div>
            </div>
            <p class="card-text text-secondary" v-text="status.body"></p>

        </div>
        <div class="card-footer p-2 d-flex justify-content-between align-items-center">
            <like-btn
                dusk="like-btn"
                :url="`/statuses/${status.id}/likes`"
                :model="status">
            </like-btn>

            <div class="text-secondary mr-2">
                <i class="far fa-thumbs-up"></i>
                <span dusk="likes-count">{{status.likes_count}}</span>
            </div>
        </div>
        <div class="card-footer">

            <comment-list
                :comments="status.comments"
                :status-id="status.id"
            ></comment-list>

            <form @submit.prevent="addComment" v-if="isAuthenticated">
                <div class="d-flex align-items-center">
                    <img class="rounded shadow-sm float-left mr-2"
                         width="34px"
                         :src="currentUser.avatar"
                         :alt="currentUser.name">
                    <div class="input-group">
                        <textarea v-model="newComment"
                                  class="form-control border-0 shadow-sm"
                                  name="comment"
                                  placeholder="Type a comment"
                                  rows="1"
                                  required
                        ></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary " dusk="comment-btn">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import LikeBtn from "./LikeBtn";
    import CommentList from "./CommentList";

    export default {
        components: {
            LikeBtn,
            CommentList
        },
        data() {
            return {
                newComment: '',
            }
        },
        props: {
            status: {
                type: Object,
                required: true
            }
        },

        methods: {
            addComment() {
                axios.post(`/statuses/${this.status.id}/comments`, {body: this.newComment})
                    .then(res => {
                        this.newComment = ''
                        EventBus.$emit(`statuses.${this.status.id}.comments`, res.data.data);
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
