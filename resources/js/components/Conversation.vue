<template>
    <div class="conversation">
        <h1>{{ contact ? contact.partner.name : 'Select a Contact'}}</h1>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage" v-if="contact"/>
    </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed';
    import MessageComposer from './MessageComposer';

    export default {
        props: {
            myId: {
                type: String
            },
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            }
        },
        methods: {
            sendMessage(text) {
                if (!this.contact){
                    return;
                }
                axios.post('/messages', {
                    chat_id: this.contact.id,
                    to: this.contact.partner.id,
                    from: this.myId,
                    text: text
                }).then((response) => {
                    this.$emit('newMessage', response.data);
                })
            }
        },
        components: {MessagesFeed, MessageComposer}
    }
</script>

<style lang="scss" scoped>
    .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        h1 {
            font-size: 20px;
            padding: 10px;
            margin: 0;
            border-bottom: 1px dashed lightgray;
        }
    }
</style>
