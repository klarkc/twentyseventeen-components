<template id="twenty-post">
    <div>
        <article>
            <div class="entry-header">
                <slot name="entry-header"></slot>
            </div>
            <div class="entry-content" @mouseup="openComments">
                <slot name="entry-content"></slot>
            </div>
        </article>
        
        <comment-grid
            base-u-r-l="https://wordpress-webcmp-test.firebaseio.com"
            api-key="AIzaSyDyV2nPmTDfctvI1Qbpr7gev3RnFu3YSwA"
            node-name="primeiro post">
        </comment-grid>
    </div>
</template>

<script>
module.exports = {
    template: '#twenty-post',
    methods: {
        openComments() {
            
        }
    }
}
</script>

<style scoped>
.entry-content p {
    font-style: italic;
}
</style>
