<template>
    <div class="composer">
        <textarea v-model="message" @keydown.enter="send" placeholder="Message...."></textarea>
        <button v-on:click="send" class="btn" style="padding: 1.3rem 1.3rem; margin-right: 10px"><i style="transform: scale(1.5); padding-left: 0;" class="fas fa-paper-plane"></i></button>
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
        margin: 10px 5px 10px 10px;
        resize: none;
        border-radius: 3px;
        padding: 6px;
    }
</style>
