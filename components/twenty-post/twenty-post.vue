<template>
    <div :style="containerStyle">
        <transition name="slide-fade">
            <article v-if="inViewport">
                    <div class="entry-header">
                        <slot name="entry-header"></slot>
                    </div>
                <div class="entry-content">
                    <slot name="entry-content"></slot>
                </div>
            </article>
        </transition>
    </div>
</template>

<script>
module.exports = {
  props: {
    isSingle: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      inViewport: true,
      containerStyle: {}
    };
  },
  methods: {
    isElementInViewport() {
      const el = this.$el;
      const rect = el.getBoundingClientRect();
      return (
        rect.top + rect.height * 0.9 >= 0 &&
        rect.left + rect.width * 0.9 >= 0 &&
        rect.bottom - rect.height * 0.9 <=
          (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right - rect.width * 0.9 <=
          (window.innerWidth || document.documentElement.clientWidth)
      );
    },
    setAnimation() {
      this.containerStyle.minHeight = this.$el.clientHeight + "px";
      this.inViewport = false;
      window.addEventListener(
        "scroll",
        debounce(() => {
          if (this.isElementInViewport()) {
            this.inViewport = true;
          } else {
            this.inViewport = false;
          }
        }, 50)
      );
    }
  },
  mounted() {
    if (!this.isSingle) this.setAnimation();
  }
};
</script>

<style scoped>
.entry-content p {
  font-style: italic;
}

.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(-50%);
  opacity: 0;
}
</style>
