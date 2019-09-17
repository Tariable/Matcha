<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                        <h1 v-bind:title="menu">{{ title }}</h1>
                        <p v-text="content"></p>
                        <input type="text" v-model="content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                title: 'Pashok',
                content: 'Kok',
                menu: 'Menu'
            }
        }
    }
</script>
