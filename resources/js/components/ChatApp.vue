<template>
    <div id="chat-app">
        <Conversation :contact="selectedContact" :messages="messages" @newMessage="saveNewMessage"/>
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
                    console.log(this.contacts);
                });
        },
        methods: {
            startConversationWith(contact) {
                axios.get(`/chats/${contact.chat_id}`)
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
                alert(message.text);
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
