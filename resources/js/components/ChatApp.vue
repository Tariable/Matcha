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
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.handleIncoming(e.message);
                });

            axios.get('/profiles/contacts')
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
            },
            handleIncoming(message){
                if(this.selectedContact && message.from === this.selectedContact.id) {
                    this.saveNewMessage(message);
                    return;
                }
                // this.updateUnreadCount(contact, false);
            },
            updateUnreadCount(contact, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== contact.id){
                        return single;
                    } else {
                        if (reset)
                            single.unread = 0;
                        else
                            single.unread += 1;
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
