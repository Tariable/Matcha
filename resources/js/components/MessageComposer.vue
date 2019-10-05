<template>
    <div class="composer">
        <textarea v-model="message" @keydown.enter="send" placeholder="Message...."></textarea>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                message: ''
            }
        },
        methods: {
            send(e){
                e.preventDefault();
                if(this.message === ''){
                    return;
                }
                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
    .composer {
        display: flex;
        align-items: center;
    }
    .composer textarea {
        width: 90%;
        margin: 10px;
        resize: none;
        border-radius: 3px;
        padding: 6px;
    }
</style>
