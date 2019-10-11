<template>
    <div class="contacts-list ">
        <ul>
            <li v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)"
                :class="{'selected': contact === selected}">
                <div class="contact">
                    <div class="avatar-box">
                        <img v-bind:src="contact.photo.path">
                    </div>

                    <div class="message-box">
                        <p class="name">{{ contact.partner.name }}</p>
                        <p class="last_message_text">{{ contact.message.text | ellipsis}}</p>
                    </div>

                    <div class="info-box">
                        <p class="last_message_from" style="text-align: center;" v-if="+myId !== contact.message.from">
                            ->
                        </p>
                        <p class="last_message_from" style="text-align: center;" v-else=""><-</p>
                        <p class="last_message_created_at" style="text-align: right;">{{
                            contact.message.created_at.split(' ')[1] }}</p>
                        <span class="unread" v-if="contact.unread">{{ contact.unread }}</span></div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            contacts: {
                type: Array,
                default: []
            },
            myId: {
                type: String
            }
        },
        data() {
            return {
                selected: this.contacts.length ? this.contacts[0] : null
            };
        },
        methods: {
            selectContact(contact) {
                this.selected = contact;
                this.$emit('selected', contact)
            }
        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    return contact.message.created_at;
                }]).reverse();
            }
        },
        filters: {
            ellipsis(val) {
                if(val.length > 15) {
                    return val.slice(0,14) + "...";
                }
                return val;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .contacts-list {
        flex: 2;
        max-height: 100%;
        height: 600px;
        overflow: auto;

        ul {
            list-style-type: none;
            padding-left: 0;
            margin-top: 0;

            li {
                display: flex;
                border-bottom: 0.5px solid #aaaaaa;
                border-radius: 5px;
                height: 80px;
                position: relative;
                cursor: pointer;

                &.selected {
                    background: #f5bdbd;
                    border-radius: 5px;
                }

                span.unread {
                    background: rgba(255, 0, 80, 1);
                    color: #fff;
                    position: absolute;
                    top: 20px;
                    display: flex;
                    font-weight: 700;
                    min-width: 20px;
                    justify-content: center;
                    align-items: center;
                    line-height: 20px;
                    font-size: 12px;
                    border-radius: 50%;
                }

                .avatar {
                    flex: 1 0;
                    display: flex;
                    align-items: center;
                    img {
                        width: 35px;
                        border-radius: 50%;
                        margin-left: 5px;
                    }
                }

                .contact {
                    flex: 3;
                    font-size: 15px;
                    overflow: hidden;
                    display: flex;
                    flex-direction: row;
                    justify-content: space-around;
                    align-items: center;

                    p {
                        margin: 0;

                        &.name {
                            font-weight: bold;
                        }
                    }

                    .message-box {
                        flex: 3 0 60%;
                    }

                    .info-box {
                        flex: 1 0 20%;
                    }

                    .avatar-box {
                        flex: 1;
                        display: flex;
                        align-items: center;
                        img {
                            width: 50px;
                            border-radius: 25%;
                            margin: 5px;
                        }
                    }
                }
            }
        }
    }
</style>
