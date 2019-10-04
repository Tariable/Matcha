<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :class="`message${checkTypeOfMessage(message, contact)}`" :key="message.id">
                <div class="text">
                    {{ message.text }}
                </div>
                <div class="data">
                    {{ message.created_at }}
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            }
        },
        methods: {
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            },
            checkTypeOfMessage(message, contact) {
                let type;
                switch (message.from) {
                    case 0:
                        type = ' systemMessage';
                        break;
                    case contact.partner.id:
                        type = ' received';
                        break;
                    default:
                        type = ' sent';
                }
                return type;
            }
        },
        watch: {
            contact(contact) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .feed {
        background: #f0f0f0;
        height: 100%;
        max-height: 470px;
        overflow: scroll;
        ul {
            list-style-type: none;
            padding: 5px;
            li {
                &.message {
                    margin: 10px 0;
                    width: 100%;
                    .text {
                        max-width: 200px;
                        border-radius: 5px;
                        padding: 12px;
                        display: inline-block;
                    }
                    &.sent {
                        text-align: right;
                        .text {
                            background: #b2b2b2;
                        }
                    }
                    &.received {
                        text-align: left;
                        .text {
                            background: #81c4f9;
                        }
                    }
                    &.systemMessage {
                        text-align: center;
                        .text {
                            background: rgba(249, 89, 91, 0.35);
                        }
                    }
                }
            }
        }
    }
</style>
