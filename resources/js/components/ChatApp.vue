<template>
    <div id="chat-app">
        <Conversation :myId="myId" :contact="selectedContact" :messages="messages" @newMessage="saveNewMessage"/>
        <ContactsList :myId="myId" :contacts="contacts" @selected="startConversationWith"/>
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactsList from './ContactsList';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                selectedContact: null,
                messages: [],
                contacts: [],
                myId: document.querySelector("meta[name='auth_id']").getAttribute('content')
            };
        },
        mounted() {
            Echo.private(`chats.${this.user.id}`)
                .listen('UpdateChat', (e) => {
                    this.handleIncoming(e.chat);
                });

            axios.get('/chats')
                .then((response) => {
                    this.contacts = response.data;
                });
        },
        methods: {
            startConversationWith(contact) {
                this.updateUnreadCount(contact, true);
                axios.get(`/chats/${contact.pivot.chat_id}`)
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
            },
            saveNewMessage(message) {
                this.messages.push(message);
                this.selectedContact.message.text = message.text;
                this.selectedContact.message.created_at = message.created_at;
                this.selectedContact.message.from = message.from;
            },
            handleIncoming(chat){
                if(this.selectedContact && chat.message.from === this.selectedContact.partner.id) {
                    this.saveNewMessage(chat.message);
                    return;
                }
                this.updateUnreadCount(chat, false);
            },
            updateUnreadCount(chat, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== chat.id){
                        return single;
                    } else {
                        if (reset)
                            single.unread = 0;
                        else
                            single.unread += 1;
                            single.message = chat.message;
                        return single;
                    }
                })
            }
        },
        components: {Conversation, ContactsList}
    }
</script>

<style lang="scss" scoped>
    .chat-app {
        display: flex;
    }
</style>
