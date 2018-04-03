<template>
    <div>
        <article>
            <div class="entry-header">
                <slot name="entry-header"></slot>
            </div>
            <div class="entry-content">
                <slot name="entry-content"></slot>
            </div>
        </article>
    </div>
</template>

<script>
module.exports = {
  props: {
    isSingle: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<style scoped>
.entry-content p {
  font-style: italic;
}
</style>
