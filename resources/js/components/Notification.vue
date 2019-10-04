<template>
    <div id="Match">
        <div class="notification" v-if="notification">
            <a class="nav-link" href="/messages" v-text="notification"></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                notification: null
            };
        },
        mounted() {
            Echo.private(`matches.${this.user.id}`)
                .listen('NewMatch', (e) => {
                    this.displayNotification(e.match);
                });
            Echo.private(`chats.${this.user.id}`)
                .listen('UpdateChat', (e) => {
                    this.displayNotification(e.chat);
                });
        },
        methods: {
            displayNotification(notification) {
                console.log(notification);
                this.notification = notification.type;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .notification {
        /*display: flex;*/
    }
</style>
