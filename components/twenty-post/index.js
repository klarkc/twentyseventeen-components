export default {
    template: '#twenty-post',
    data() {
        return {
            loading: false
        }
    },
    mounted() {
        setTimeout(function() {
            this.loading = true
        }, 3000)
    }
}