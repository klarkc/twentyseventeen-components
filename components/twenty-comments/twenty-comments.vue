<template>
    <comment-grid
        :base-u-r-l="baseUrl"
        :api-key="apiKey"
        :node-name="postId">
    </comment-grid>
</template>

<script>
module.exports = {
  name: "twenty-comments",
  data() {
    return {
      baseUrl: "https://wordpress-webcmp-test.firebaseio.com",
      apiKey: "AIzaSyDyV2nPmTDfctvI1Qbpr7gev3RnFu3YSwA"
    }
  },
  props: {
      postId: String,
  }
}
</script>

