export default {
    data: function() {
        return {
            loading: false
        }
    },
    mounted: function() {
        setTimeout(function() {
            this.loading = true
        }, 3000)
    }
}