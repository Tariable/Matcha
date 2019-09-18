<template>
    <div id="chat-app">
        <p>Chat App</p>
        <Conversation :contact="selectedContact" :messages="messages"/>
        <ContactsList :contacts="contacts"/>
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
                contacts: []
            };
        },
        mounted() {
            console.log(this.user);
            axios.get('/profiles/all')
                .then((response) => {
                    console.log(response.data);
                    this.contacts = response.data;
                });
        },
        components: {Conversation, ContactsList}
    }
</script>
