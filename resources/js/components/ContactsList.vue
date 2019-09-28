<template>
    <div class="contacts-list">
        <ul>
            <li v-for="(contact, index) in contacts" :key="contact.id" @click="selectContact(index, contact)" :class="{'selected': index === selected}" >
                <div class="contact">
                    <p class="name">{{ contact[0] }}</p>
                    <p>{{ contact[1].from }}</p>
<!--                    <p class="last_message_from" v-if="myId !== contact[1].from">-></p>-->
<!--                    <p class="last_message_from" v-else=""><-</p>-->
                    <p class="last_message_text">{{ contact[1].text }}</p>
                    <p class="last_message_created_at">{{ contact[1].created_at }}</p>
                    <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
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
                default : []
            },
            myId: String
        },
        data() {
            return {
                selected: 0
            };
        },
        methods: {
            selectContact(index, contact) {
                this.selected = index;
                this.$emit('selected', contact[1])
            }
        }
    }
</script>

<style lang="scss" scoped>
    .contacts-list {
        flex: 2;
        max-height: 100%;
        height: 600px;
        overflow: scroll;
        border-left: 1px solid #a6a6a6;

        ul {
            list-style-type: none;
            padding-left: 0;
            li {
                display: flex;
                padding: 2px;
                border-bottom: 1px solid #aaaaaa;
                height: 80px;
                position: relative;
                cursor: pointer;
                &.selected {
                    background: #dfdfdf;
                }
                span.unread {
                    background: #82e0a8;
                    color: #fff;
                    position: absolute;
                    right: 11px;
                    top: 20px;
                    display: flex;
                    font-weight: 700;
                    min-width: 20px;
                    justify-content: center;
                    align-items: center;
                    line-height: 20px;
                    font-size: 12px;
                    padding: 0 4px;
                    border-radius: 3px;
                }
                .avatar {
                    flex: 1;
                    display: flex;
                    align-items: center;
                    img {
                        width: 35px;
                        border-radius: 50%;
                        margin: 0 auto;
                    }
                }
                .contact {
                    flex: 3;
                    font-size: 10px;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    p {
                        margin: 0;
                        &.name {
                            font-weight: bold;
                        }
                    }
                }
            }
        }
    }
</style>
