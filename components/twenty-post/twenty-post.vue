<template id="twenty-post">
    <div>
        <article>
            <div class="entry-header">
                <slot name="entry-header"></slot>
            </div>
            <div class="entry-content" @mouseup="onMouseUp">
                <slot name="entry-content"></slot>
            </div>
        </article>
        
        <comment-grid
            :base-u-r-l="baseUrl"
            :api-key="apiKey"
            :node-name="commentId">
        </comment-grid>
    </div>
</template>

<script>
module.exports = {
    template: '#twenty-post',
    data() {
        return {
            selectedText: '',
            commentId: '',
            baseUrl: 'https://wordpress-webcmp-test.firebaseio.com',
            apiKey: 'AIzaSyDyV2nPmTDfctvI1Qbpr7gev3RnFu3YSwA',
        }
    },
    computed: {
        postId() {
            return (
                this.$el &&
                this.$el.id
            )
        },
    },
    methods: {
        getSelectionText() {
            let text = "";
            if (window.getSelection) {
                text = window.getSelection().toString();
            } else if (document.selection && document.selection.type != "Control") {
                text = document.selection.createRange().text;
            }
            return text;
        },
        onMouseUp() {
            this.selectedText = this.getSelectionText();
            const entryContent = this.$slots['entry-content'][0];
            const text = (
                entryContent &&
                entryContent.elm &&
                entryContent.elm.innerText
            );
            const startIndex = text.indexOf(this.selectedText);
            if (startIndex > -1) {
                this.commentId = JSON.stringify({
                    postId: this.postId,
                    start: startIndex,
                    end: this.selectedText.length,
                });
            }
        }
    }
}
</script>

<style scoped>
.entry-content p {
    font-style: italic;
}
</style>
