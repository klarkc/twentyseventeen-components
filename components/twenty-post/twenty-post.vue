<template>
    <div :style="containerStyle">
      <article>
        <transition name="slide-right">
            <div class="entry-header"
                 v-if="inViewport">
                <slot name="entry-header">
                </slot>
            </div>
        </transition>
        <transition name="slide-left">
        <div class="entry-content"
             v-if="inViewport">
            <slot name="entry-content">
            </slot>
        </div>
        </transition>
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
        rect.top + rect.height * 0.4 >= 0 &&
        rect.left + rect.width * 0.9 >= 0 &&
        rect.bottom - rect.height * 0.9 <=
          (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right - rect.width * 0.9 <=
          (window.innerWidth || document.documentElement.clientWidth)
      );
    },
    setAnimation() {
      this.containerStyle.minHeight = this.$el.clientHeight + "px";
      this.containerStyle.overflow = 'hidden';
      this.inViewport = false;
      window.addEventListener(
        "scroll",
        debounce(() => {
          if (this.isElementInViewport()) {
            this.inViewport = true;
          } else {
            this.inViewport = false;
          }
        }, 30)
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

.slide-left-enter-active,
.slide-right-enter-active {
  transition: all 0.3s ease;
}
.slide-left-leave-active,
.slide-right-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-left-enter,
.slide-left-leave-to,
.slide-right-enter,
.slide-right-leave-to {
  opacity: 0;
}

.slide-left-enter,
.slide-left-leave-to {
  transform: translateX(-50%);
}

.slide-right-enter,
.slide-right-leave-to {
  transform: translateX(50%);
}
</style>
